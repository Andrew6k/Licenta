# from scholarly import scholarly
# from scholarly import ProxyGenerator

# pg = ProxyGenerator()
# pg.FreeProxies()
# scholarly.use_proxy(pg)

# Retrieve the author's data, fill-in, and print
# Get an iterator for the author results
# search_query = scholarly.search_author('Mihaela Breaban')
# Retrieve the first result from the iterator
# first_author_result = next(search_query)
# scholarly.pprint(first_author_result)

# Retrieve all the details for the author
# author = scholarly.fill(first_author_result )
# scholarly.pprint(author)

# Take a closer look at the first publication
# first_publication = author['publications'][0]
# first_publication_filled = scholarly.fill(first_publication)
# scholarly.pprint(first_publication_filled)

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

data = {}
data["authors"] = ["Mihaela Breaban"]
data["authors"].append("Cirjanu")
if "Mihaela" in data["authors"]:
    print("yes")
print(data)

data["nr"] = ["11","2","3"]
if "11" in data["nr"]:
    print("ye")
else:
    print("no")

if len(data["authors"])<2:
    print("mhm")
else:
    print(len(data["nr"]))
data["pub"] = []
data["pub"].append("nr")
print(data["pub"])