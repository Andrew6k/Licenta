from scholarly import scholarly
from scholarly import ProxyGenerator
import mysql.connector

def insert_pub(title, year, conference, summary, citations, link, author_id):
    publication_sql = "INSERT INTO publications (title, year, conference, summary, citations, link) VALUES (%s, %s, %s, %s, %s, %s)"
    publication = (title, year, conference, summary, citations, link)
    cursor.execute(publication_sql, publication)

    publication_id = cursor.lastrowid

    author_publication_sql = "INSERT INTO author_publications (author_id, publication_id) VALUES (%s, %s)"
    author_publication = (author_id, publication_id)
    cursor.execute(author_publication_sql, author_publication)

    conn.commit()

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

    pg = ProxyGenerator()
    pg.FreeProxies()
    scholarly.use_proxy(pg)

    select_query = "SELECT * FROM authors"
    cursor.execute(select_query)

    rows = cursor.fetchall()
    for row in rows:

        id = row[0]
        name = row[1]

        sql = "SELECT title, year from publications join author_publications on id = publication_id WHERE author_id = %s"
        cursor.execute(sql,(id,))
        result = cursor.fetchall()

        pubsDB = {}
        for pub_title in result:
            pubsDB[pub_title[0]] = pub_title[1]

        search_query = scholarly.search_author(name)
        first_author_result = next(search_query)
        author = scholarly.fill(first_author_result, sections=['basics', 'publications'] )

        for article in author['publications']:
            pub = article

            if ((int(pub['num_citations'])>= 2) and 
            ('pub_year' in pub['bib']) and 
            (int(pub['bib']['pub_year']) >= 2020)): 
                
                if pub['bib']['title'] not in pubsDB:
                    pubsDB[pub['bib']['title']] = pub['bib']['pub_year']
                    pub_fill = scholarly.fill(pub, sections=['bib'])

                    conference = make_string(pub_fill['bib']['citation'])
                    
                    if 'abstract' in pub_fill['bib']: #here
                        print("Exists")
                        abstract = pub_fill['bib']['abstract']
                    else:
                        abstract = "Not available"
                    
                    if 'pub_url' in pub_fill:
                        link = pub_fill['pub_url']
                    else:
                        link = "Not available"

                    insert_pub(pub_fill['bib']['title'], int(pub_fill['bib']['pub_year']), conference, abstract, int(pub_fill['num_citations']), link)

                    otherAuth = pub_fill['bib']['author'].split(" and ")
                    for auth in otherAuth:
                        if auth in data["authD"] and auth != author["name"]:
                            values = ([auth], [pub['bib']['title']])
                            
                            

        affiliation = author["affiliation"]
        email_domain = author["email_domain"]
        citations = int(author["citedby"])
        
        # Update the data as needed
        update_query = "UPDATE authors SET affiliation=%s, email_domain=%s, citations=%d WHERE id=%d"
        data = (affiliation, email_domain, citations, id)
        cursor.execute(update_query, data)
    conn.commit()

    select_query = "SELECT * FROM publications"
    cursor.execute(select_query)

    rows = cursor.fetchall()
    for row in rows:
        id = row[0]
        name = row[1]

        pub_fill = scholarly.fill(name, sections=['bib'])
        if 'abstract' in pub_fill['bib']: 
            print("Exists")
            abstract = pub_fill['bib']['abstract']
        else:
             abstract = "Not available"
        citations = int(pub_fill['num_citations'])

        update_query = "UPDATE publications SET summary=%s, citations=%d WHERE id=%d"
        data = (abstract, citations, id)
        cursor.execute(update_query, data)
    conn.commit()
    print("Succes!")