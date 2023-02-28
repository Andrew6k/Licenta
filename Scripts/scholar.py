from scholarly import scholarly
from scholarly import ProxyGenerator
from cryptography.fernet import Fernet
import mysql.connector
import random
import string
import time

def get_pass():
    alph = string.ascii_lowercase + string.digits + "!#&()?/"
    keyF = Fernet.generate_key()
    result = ''.join(random.choice(alph) for i in range(6))
    fernet = Fernet(keyF)
    enc = fernet.encrypt(result.encode())
    return enc, fernet

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

    id1 = 0
    id2 = 0
    id3 = 0
    nr_pub = 0
    nr_aut = 0

    data = {}
    data["authors"] = []
    data["domains"] = []
    data["authD"] = []

    authID = {} #saves primary key for every author
    domID = {} #saves primary key for every domain
    pubID = {} #saves primary key for every publications


    domKeys = []
    pubKeys = []

    data["authors"].append("Mihaela Elena Breaban")

    # search_query = scholarly.search_author('Mihaela Elena Breaban')
    # first_author_result = next(search_query)
    # author = scholarly.fill(first_author_result, sections=['basics', 'publications', 'coauthors'] )
    # # print(author)
    # data["authors"].append(author['name'])

    # for coauth in author['coauthors']:
    #     if coauth['affiliation'].contains("Cuza"):
    #          data['authors'].append(coauth['name'])

    for author_name in data["authors"]:
        if nr_aut == 15:
            break
        nr_pub = 0
        search_query = scholarly.search_author(author_name)
        first_author_result = next(search_query)
        time.sleep(1)
        author = scholarly.fill(first_author_result, sections=['basics', 'publications', 'coauthors'] )
        
        for coauth in author['coauthors']:
            if "Cuza" in coauth['affiliation']:
                data['authors'].append(coauth['name'])

        mail = author["name"].lower().replace(" ",".")
        password, fernet = get_pass()

        if ((author["name"] not in data["authD"]) and nr_aut <15): 
            nr_aut += 1
            values = (author["name"], author["affiliation"], author["email_domain"],
             int(author["citedby"]), mail, fernet.decrypt(password).decode())

            insert_query = f"""
            INSERT INTO authors (name, affiliation, email_domain, citations, mail, password)
            VALUES {values}
            """

            cursor.execute(insert_query)

            # conn.commit()
            # with open("output.txt", "a") as file:
            #     file.write(author["name"] + "\n")

            data["authD"].append(author["name"]) 
            id1 = cursor.lastrowid
            authID[author["name"]] = id1


        for domain in author["interests"]:
            # domain = str(interest)
            # print(domain)
            if domain not in data["domains"]:
                #print(domain)
                values = [domain]

                insert_query = "INSERT INTO domains (domain) VALUES (%s)"
                cursor.execute(insert_query, values)
                # conn.commit()
                data["domains"].append(domain) 
                domID[domain] = cursor.lastrowid

                # with open("output.txt", "a") as file:
                #     file.write(domain + " " + str(domID[domain]) + "\n")

            # id2 = cursor.lastrowid
            id2 = domID[domain]
            values = (id1, id2)
            if values not in domKeys:
                domKeys.append(values)
                insert_query = f"""
                INSERT INTO author_domains (author_id, domain_id)
                VALUES {values}
                """

                cursor.execute(insert_query)
                # conn.commit()
            # id2 = cursor.lastrowid

        for article in author['publications']:
            if nr_pub >= 15:
                break
            pub = article
            if ((int(pub['num_citations'])>= 2) and 
            ('pub_year' in pub['bib']) and 
            (int(pub['bib']['pub_year']) >= 2010)): 
                print(nr_pub)
                nr_pub += 1
                time.sleep(2)
                if pub['bib']['title'] not in data["pub"]:
                    data["pub"].append(pub['bib']['title'])
                    pub_fill = scholarly.fill(pub, sections=['bib'])

                    # with open("output.txt", "a") as file:
                    #     file.write(pub['bib']['title'] + "\n")

                    conference = make_string(pub_fill['bib']['citation'])
                    # conference = ''.join(i for i in pub_fill['bib']['citation'] if not i.isdigit() or i == ',')

                    if 'abstract' in pub_fill['bib']: #here
                        print("Exists")
                        abstract = pub_fill['bib']['abstract']
                    else:
                        abstract = "Not available"
                    
                    if 'pub_url' in pub_fill:
                        link = pub_fill['pub_url']
                    else:
                        link = "Not available"

                    values = (pub_fill['bib']['title'], int(pub_fill['bib']['pub_year']), conference, abstract, int(pub_fill['num_citations']), link)

                    insert_query = f"""
                    INSERT INTO publications (title, year, conference, summary, citations, link)
                    VALUES {values}
                    """

                    cursor.execute(insert_query)
                    # conn.commit()

                    pubID[pub['bib']['title']] = cursor.lastrowid

                    otherAuth = pub_fill['bib']['author'].split(" and ")
                    for auth in otherAuth:
                        if auth in data["authD"] and auth != author["name"]:
                            values = (authID[auth], pubID[pub['bib']['title']])
                            insert_query = f"""
                                INSERT INTO author_publications (author_id, publication_id)
                                VALUES {values}
                                """
                            cursor.execute(insert_query)
                            


                id3 = pubID[pub['bib']['title']]
                values = (id1, id3)

                if values not in pubKeys:

                    pubKeys.append(values)
                    insert_query = f"""
                    INSERT INTO author_publications (author_id, publication_id)
                    VALUES {values}
                    """

                    cursor.execute(insert_query)
        conn.commit()

    #export list, check after
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