from scholarly import scholarly
from scholarly import ProxyGenerator
import mysql.connector
import random
import string

def get_pass():
    alph = string.ascii_lowercase + string.digits + "!#&()?/"
    result = ''.join(random.choice(alph) for i in range(6))
    return result


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

data = {}
data["authors"] = []
data["pub"] = []
data["domains"] = []

domID = {}

search_query = scholarly.search_author('Mihaela Breaban')
first_author_result = next(search_query)
author = scholarly.fill(first_author_result )
print(author)


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
        # domID[domain] = cursor.lastrowid

    id2 = cursor.lastrowid
    values = (id1, id2)

    insert_query = f"""
    INSERT INTO author_domains (author_id, domain_id)
    VALUES {values}
    """

    cursor.execute(insert_query)
    conn.commit()
    # id2 = cursor.lastrowid


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