from scholarly import scholarly
from scholarly import ProxyGenerator
import mysql.connector
import random
import string

def get_pass():
    alph = string.ascii_lowercase + string.digits + "!#&()?/"
    result = ''.join(random.choice(alph) for i in range(6))
    return result

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

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="scholar"
)

cursor = conn.cursor()


pg = ProxyGenerator()
pg.FreeProxies()
scholarly.use_proxy(pg)

id1 = 0
id2 = 0
id3 = 0
nr_pub = 0

data = {}
data["authors"] = []
data["pub"] = []
data["domains"] = []

domID = {} #saves primary key for every domain
pubID = {}


search_query = scholarly.search_author('Mihaela Breaban')
first_author_result = next(search_query)
author = scholarly.fill(first_author_result, sections=['basics', 'publications'] )
# print(author)


mail = author["name"].lower().replace(" ",".")
password = get_pass()

if author["name"] not in data["authors"]: #se reseteaza la run
    values = (author["name"], author["affiliation"], author["email_domain"], int(author["citedby"]), mail, password)

    insert_query = f"""
    INSERT INTO authors (name, affiliation, email_domain, citations, mail, password)
    VALUES {values}
    """

    cursor.execute(insert_query)
    conn.commit()
    data["authors"].append(author["name"]) 
    id1 = cursor.lastrowid


for domain in author["interests"]:
    # domain = str(interest)
    # print(domain)
    if domain not in data["domains"]:
        #print(domain)
        values = [domain]

        insert_query = """INSERT INTO domains (domain) VALUES (%s)"""
        cursor.execute(insert_query, values)
        conn.commit()
        data["domains"].append(domain) 
        domID[domain] = cursor.lastrowid

    # id2 = cursor.lastrowid
    id2 = domID[domain]
    values = (id1, id2)

    insert_query = f"""
    INSERT INTO author_domains (author_id, domain_id)
    VALUES {values}
    """

    cursor.execute(insert_query)
    conn.commit()
    # id2 = cursor.lastrowid

for article in author['publications']:
    if nr_pub >= 15:
        break
    pub = article
    if int(pub['bib']['pub_year']) > 2010:
        nr_pub += 1
        if pub['bib']['title'] not in data["pub"]:
            data["pub"].append(pub['bib']['title'])
            pub_fill = scholarly.fill(pub, sections=['bib'])

            conference = make_string(pub_fill['bib']['citation'])
            # conference = ''.join(i for i in pub_fill['bib']['citation'] if not i.isdigit() or i == ',')

            values = (pub_fill['bib']['title'], int(pub_fill['bib']['pub_year']), conference, pub_fill['bib']['abstract'], int(pub_fill['num_citations']))

            insert_query = f"""
            INSERT INTO publications (title, year, conference, summary, citations)
            VALUES {values}
            """

            cursor.execute(insert_query)
            conn.commit()

            pubID[article['bib']['title']] = cursor.lastrowid

        id3 = pubID[article['bib']['title']]
        values = (id1, id3)

        insert_query = f"""
        INSERT INTO author_publications (author_id, publication_id)
        VALUES {values}
        """

        cursor.execute(insert_query)
        conn.commit()


cursor.close()
conn.close()

#scholarly.pprint(next(search_query))
# first_publication = author['publications'][20]
# first_publication_filled = scholarly.fill(first_publication)
# print(first_publication_filled['bib']['author'].split(" and "))
# print(first_publication_filled)

















# publication_titles = [pub['bib']['title'] for pub in author['publications']]
# print(publication_titles)

#print(scholarly.citedby(first_publication_filled))

#help(scholarly)
# Retrieve the first result from the iterator
# first_author_result = next(search_query)
# scholarly.pprint(first_author_result)

# # Retrieve all the details for the author
# author = scholarly.fill(first_author_result )
# scholarly.pprint(author)

# # Take a closer look at the first publication
# first_publication = author['publications'][0]
# first_publication_filled = scholarly.fill(first_publication)
# scholarly.pprint(first_publication_filled)

# # Print the titles of the author's publications
# publication_titles = [pub['bib']['title'] for pub in author['publications']]
# print(publication_titles)

# # Which papers cited that publication?
# citations = [citation['bib']['title'] for citation in scholarly.citedby(first_publication_filled)]
# print(citations)