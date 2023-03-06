import requests
from bs4 import BeautifulSoup
import re
import mysql.connector

conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="scholar"
        )

cursor = conn.cursor()
# Set the URL for the Google Scholar search results page for the publication
pub_url = "https://scholar.google.com/scholar?oi=bibs&hl=ro&cites=14469474580644534157&start={}"
# url = 'https://scholar.google.com/citations?user=YOUR_USER_ID_HERE&hl=en&cstart={}&pagesize=100'

start = 0

while True:
# Send a GET request to the URL and parse the HTML with Beautiful Soup
    response = requests.get(pub_url.format(start))
    soup = BeautifulSoup(response.content, 'html.parser')

    # Extract the titles and authors of the citing articles from the HTML
    citing_articles = []
    for article in soup.find_all('div', {'class': 'gs_r gs_or gs_scl'}):
        title = article.find('h3', {'class': 'gs_rt'}).text
        title = re.sub(r'\[.*?\]', '', title)
        authors = article.find('div', {'class': 'gs_a'}).text.split('-')[0].strip()
        a_tag = article.find('a', href = True)['href']
        citing_articles.append({'title': title, 'authors': authors, 'link': a_tag})
        
    if not citing_articles:
        break

    # Print the titles and authors of the citing articles
    for article in citing_articles:
        print(f"Title: {article['title']}")
        print(f"Authors: {article['authors']}")
        print(f"Link: {article['link']}")
        values = (article["title"], article["link"], "6")
    # if start > 90:
    #     break
    start += 10
    # insert_query = f"""
    # INSERT INTO citations (title, link, publication_id)
    # VALUES {values}
    # """

#     cursor.execute(insert_query)
# conn.commit()

cursor.close()
conn.close()

    # citations_authors = article['authors'].split(",")
    # print(citations_authors)
