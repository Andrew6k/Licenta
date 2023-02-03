from scholarly import scholarly
from scholarly import ProxyGenerator
import mysql.connector

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

        search_query = scholarly.search_author(name)
        first_author_result = next(search_query)
        author = scholarly.fill(first_author_result, sections=['basics'] )


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