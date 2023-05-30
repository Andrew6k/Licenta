from scholarly import scholarly
from scholarly import ProxyGenerator
import mysql.connector
import sys

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

    args = sys.argv
    idA = args[1]
    # nameA = args[2]
    select_query = "SELECT name FROM authors WHERE id = %s"
    cursor.execute(select_query,(idA,))
    rows = cursor.fetchall()
    for row in rows:
        nameA = row[0]

    search_query = scholarly.search_author(nameA)
    author = scholarly.fill(next(search_query),sections=['publications'])

    updateQ = "UPDATE authors SET citations = %s WHERE id = %s"
    cursor.execute(updateQ, (author['citedby'],idA,))
    
    # print([pub['bib']['title'] for pub in author['publications']])
    # ['bib']['pub_year'] / ['num_citations']
    select_query = "SELECT title, year, citations FROM publications JOIN author_publications ON publications.id = publication_id WHERE author_id = %s"
    cursor.execute(select_query,(idA,))

    newPub = {}

    #update nr of citations
    rows = cursor.fetchall()
    for row in rows:
        title = row[0]
        year = str(row[1])
        citations = str(row[2])
        # print(title + " " + year + " " + citations)
        for pub in author['publications']:
            if(title == pub['bib']['title'] and year == pub['bib']['pub_year'] and citations != str(pub['num_citations'])):
                updateQ = "UPDATE publications SET citations = %s WHERE title = %s"
                cursor.execute(updateQ, (str(pub['num_citations']),title,))
            elif(int(pub['bib']['pub_year']) > 2020):
                newPub[pub['bib']['title']] = pub['bib']['pub_year']
        conn.commit()
    print(newPub)

    # for pub in author['publications']:
    #     if pub['bib']['title'] in newPub:
    # insert in db, search authors, search citations using https://scholar.google.com/scholar?cites=id - cites_id

    #     id = row[0]
    #     name = row[1]

    #     search_query = scholarly.search_author(name)
    #     first_author_result = next(search_query)
    #     author = scholarly.fill(first_author_result, sections=['basics'] )


    #     affiliation = author["affiliation"]
    #     email_domain = author["email_domain"]
    #     citations = int(author["citedby"])
        
    #     # Update the data as needed
    #     update_query = "UPDATE authors SET affiliation=%s, email_domain=%s, citations=%d WHERE id=%d"
    #     data = (affiliation, email_domain, citations, id)
    #     cursor.execute(update_query, data)
    # conn.commit()

    # select_query = "SELECT * FROM publications"
    # cursor.execute(select_query)

    # rows = cursor.fetchall()
    # for row in rows:
    #     id = row[0]
    #     name = row[1]

    #     pub_fill = scholarly.fill(name, sections=['bib'])
    #     if 'abstract' in pub_fill['bib']: 
    #         print("Exists")
    #         abstract = pub_fill['bib']['abstract']
    #     else:
    #          abstract = "Not available"
    #     citations = int(pub_fill['num_citations'])

    #     update_query = "UPDATE publications SET summary=%s, citations=%d WHERE id=%d"
    #     data = (abstract, citations, id)
    #     cursor.execute(update_query, data)
    # conn.commit()
    # print("Succes!")