from scholarly import scholarly
from scholarly import ProxyGenerator
import mysql.connector
import requests
from bs4 import BeautifulSoup
import re

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
    cursor.execute("SELECT title, id FROM publications")

    pg = ProxyGenerator()
    pg.FreeProxies()
    scholarly.use_proxy(pg)

    results = cursor.fetchall()

    for row in results:
        value = [row[1]]
        insert_query = f"""
                SELECT name, id from authors join author_publications on author_id = authors.id where publication_id = %s
                """
        cursor.execute(insert_query, (row[1],))
        authors = cursor.fetchall()
        print(row[0])

        id_authors = {}
        authors_list = []
        
        for author in authors:
                print(author[0])
                authors_list.append(author[0])
                id_authors[author[0]] = author[1]

        # print(authors_list)
        print("-------")
        search_query = scholarly.search_pubs(row[0])
        pub = next(search_query)
        # # pub_fill = scholarly.fill(pub)
        print(pub)
        # cited_by = pub['citedby_url']
        print(pub['citedby_url'])
        url = "https://scholar.google.com" + pub["citedby_url"]
        response = requests.get(url)
        soup = BeautifulSoup(response.content, 'html.parser')

        # # Extract the titles and authors of the citing articles from the HTML
        citing_articles = []
        for article in soup.find_all('div', {'class': 'gs_r gs_or gs_scl'}):
            title = article.find('h3', {'class': 'gs_rt'}).text
            authors = article.find('div', {'class': 'gs_a'}).text.split('-')[0].strip()
            a_tag = article.find('a', href = True)['href']
            citing_articles.append({'title': title, 'authors': authors, 'link': a_tag})

        # # Print the titles and authors of the citing articles
        for article in citing_articles:
            print(f"Title: {article['title']}")
            print(f"Authors: {article['authors']}")
            values = (article["title"], article["link"], row[1])

            insert_query = f"""
            INSERT INTO citations (title, link, publication_id)
            VALUES {values}
            """

            cursor.execute(insert_query)

            citation_id = cursor.lastrowid

            direct_authors = []
            indirect_authors = []

            citations_authors = article['authors'].split(",")

            ok = 0
            for aut in authors_list:
                if aut in citations_authors:
                    ok = 1
                    direct_authors.append(aut)
            if ok == 1:
                for aut in authors_list:
                    if aut not in direct_authors:
                        indirect_authors.append(aut)

                for aut in direct_authors:
                    values = (id_authors[aut], citation_id, "Direct")

                    insert_query = f"""
                    INSERT INTO author_citations (author_id, citation_id, type)
                    VALUES {values}
                    """
                    cursor.execute(insert_query)

                for aut in indirect_authors:
                    values = (id_authors[aut], citation_id, "Indirect")

                    insert_query = f"""
                    INSERT INTO author_citations (author_id, citation_id, type)
                    VALUES {values}
                    """
                    cursor.execute(insert_query)

            # print(citations_authors)
        conn.commit()

    cursor.close()
    conn.close()
    

    ##################
    publication = "Revealing Lung Affections from CTs. A Comparative"
    search_query = scholarly.search_pubs(publication)
    pub = next(search_query)
    # # pub_fill = scholarly.fill(pub)
    print(pub)
    # cited_by = pub['citedby_url']
    print(pub['citedby_url'])
    # search_query = scholarly.search_pubs(cited_by)
    # cited_by = next(search_query)
    # print(cited_by)
    # for citation in cited_by:
    #     print("Title:", citation['bib']['title'])
    #     print("Authors:", citation['bib']['author'])

    url = "https://scholar.google.com" + pub["citedby_url"]
    # pub_url = "https://scholar.google.com/scholar?cites=13422781568225188885&as_sdt=2005&sciodt=0,5&hl=ro"
    # # Send a GET request to the URL and parse the HTML with Beautiful Soup
    response = requests.get(url)
    soup = BeautifulSoup(response.content, 'html.parser')

    # # Extract the titles and authors of the citing articles from the HTML
    citing_articles = []
    for article in soup.find_all('div', {'class': 'gs_r gs_or gs_scl'}):
        title = article.find('h3', {'class': 'gs_rt'}).text
        title = re.sub(r'\[.*?\]', '', title)
        authors = article.find('div', {'class': 'gs_a'}).text.split('-')[0].strip()
        citing_articles.append({'title': title, 'authors': authors})

    # # Print the titles and authors of the citing articles
    for article in citing_articles:
        print(f"Title: {article['title']}")
        print(f"Authors: {article['authors']}")
        # publication = article['title']
        # search_query = scholarly.search_pubs(publication)
        # pub = next(search_query)
        # print('------')
        # print(pub['bib']['author'])

# Retrieve the author's data, fill-in, and print
# Get an iterator for the author results
# search_query = scholarly.search_author('Mihaela Breaban')
# Retrieve the first result from the iterator
# first_author_result = next(search_query)
# scholarly.pprint(first_author_result)

# Retrieve all the details for the author
# author = scholarly.fill(first_author_result, sections=['basics', 'publications', 'coauthors'] )
# print(author)
print("------------")
# print(author['coauthors'][0]['name'])
# scholarly.pprint(author)

# Take a closer look at the first publication
# first_publication = author['publications'][3]
# print(first_publication['bib']['title'])
# print(first_publication['bib']['pub_year'])
# print(first_publication['bib']['citation'])
# print(first_publication['num_citations'])
# first_publication_filled = scholarly.fill(first_publication, sections=['bib'])
# print(first_publication_filled)
# print(first_publication)
# print("-------------")
# print(first_publication_filled['bib']['title'])
# print(first_publication_filled['bib']['author'].split(" and "))
# if 'num_citations' in first_publication:
#     print(first_publication['num_citations']) #
# else:
#     print("no")

# if 'pub_year' in first_publication_filled['bib']:
#     print(first_publication_filled['bib']['pub_year'])
# else:
#     print("no")
# Print the titles of the author's publications
# publication_titles = [pub['bib']['title'] for pub in author['publications']]
# print(publication_titles)

# Which papers cited that publication?
# citations = [citation['bib']['title'] for citation in scholarly.citedby(first_publication_filled)]
# print(citations)





# search_query = scholarly.search_author('Mihaela Breaban')
# author = scholarly.fill(next(search_query))
# print(author)

# Print the titles of the author's publications
# print([pub['bib']['title'] for pub in author['publications']])

# Take a closer look at the first publication
# pub = scholarly.fill(author['publications'][28])
# print(pub)

# Which papers cited that publication?
# print([citation['bib']['title'] for citation in scholarly.citedby(pub)])


# data = {}
# data["authors"] = ["Mihaela Breaban"]
# data["authors"].append("Cirjanu")
# if "Mihaela" in data["authors"]:
#     print("yes")
# print(data)

# data["nr"] = ["11","2","3"]
# if "11" in data["nr"]:
#     print("ye")
# else:
#     print("no")

# if len(data["authors"])<2:
#     print("mhm")
# else:
#     print(len(data["nr"]))
# data["pub"] = []
# data["pub"].append("nr")
# print(data["pub"])
