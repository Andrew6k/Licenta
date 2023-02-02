from scholarly import scholarly
from scholarly import ProxyGenerator
import sys
import mysql.connector

def test(name):
    cursor = conn.cursor()
    cursor.execute("SELECT id, name FROM authors WHERE name=%s", (name,))

    result = cursor.fetchall()
   

    return len(result) < 1

def testD(domain):
    cursor = conn.cursor()
    cursor.execute("SELECT id, domain FROM domains WHERE domain=%s", (domain,))

    result = cursor.fetchall()

    return len(result) < 1

def testP(article):
    cursor = conn.cursor()
    cursor.execute("SELECT id, title FROM publications WHERE title=%s", (article,))

    result = cursor.fetchall()

    return len(result) < 1


def make_string(str):
    str = str.replace('-','')
    str = str.replace(',','')
    words = str.split(" ")
    str2 = ''
    for word in words:
        if not word.isnumeric() :
            if str2 == '':
                str2 = word
            else:
                str2 = str2 + ' ' + word
    return str2

if __name__ == "__main__":
    try:
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="scholar"
            )
    except:
        print("Database not available!")
    else:
        cursor = conn.cursor()
        domKeys = []
        if len(sys.argv) > 1:
            if test(sys.argv[1]):
                sys.argv[1] = sys.argv[1].replace('-',' ')
                pg = ProxyGenerator()
                pg.FreeProxies()
                scholarly.use_proxy(pg)

                search_query = scholarly.search_author(sys.argv[1])
                first_author_result = next(search_query)
                author = scholarly.fill(first_author_result, sections=['basics', 'publications'] )

                # insert_query = "INSERT INTO authors (name, affiliation, email_domain, citations, mail, password) VALUES (%s, %s, %s, %s, %s, %s)"
                data = (sys.argv[1], author["affiliation"], author["email_domain"], int(author["citedby"]), sys.argv[2], sys.argv[3])
                insert_query = f"""
                INSERT INTO authors (name, affiliation, email_domain, citations, mail, password)
                VALUES {data}
                """
                cursor.execute(insert_query)
                conn.commit()
                id1 = cursor.lastrowid

                for domain in author["interests"]:
                    if testD(domain):
                        insert_query = "INSERT INTO author_domains (author_id, domain_id) VALUES (%d, %d)"
                        data = (id1, testD(domain))

                        cursor.execute(insert_query, data)
                        conn.commit()
                    else:
                        values = (domain,)

                        insert_query = "INSERT INTO domains (domain) VALUES (%s)"
                        cursor.execute(insert_query, values)
                        conn.commit()
                        id2 = cursor.lastrowid

                        insert_query = "INSERT INTO author_domains (author_id, domain_id) VALUES (%d, %d)"
                        data = (id1, id2)

                        if data not in domKeys:
                            domKeys.append(data)
                            cursor.execute(insert_query, data)
                            conn.commit()

                nr_pub = 0
                for article in author['publications']:
                    if nr_pub >= 15:
                        break
                    pub = article
                    if testP(pub):
                        insert_query = "INSERT INTO author_publications (author_id, publication_id) VALUES (%d, %d)"
                        data = (id1, testP(pub))

                        cursor.execute(insert_query, data)
                        conn.commit()
                    else:
                        pub_fill = scholarly.fill(pub, sections=['bib'])

                        conference = make_string(pub_fill['bib']['citation'])
                        if 'abstract' in pub_fill['bib']: #here
                            print("Exists")
                            abstract = pub_fill['bib']['abstract']
                        else:
                            abstract = "Not available"

                        values = (pub_fill['bib']['title'], int(pub_fill['bib']['pub_year']), conference, abstract, int(pub_fill['num_citations']))

                        insert_query = f"""
                        INSERT INTO publications (title, year, conference, summary, citations)
                        VALUES {values}
                        """

                        cursor.execute(insert_query)
                        conn.commit()

                        id3 = cursor.lastrowid
                        insert_query = "INSERT INTO author_publications (author_id, publication_id) VALUES (%d, %d)"
                        data = (id1, id3)

                        cursor.execute(insert_query, data)
                        conn.commit()

            else:
                print("The user already exists")
        else:
            print("No arguments passed")
