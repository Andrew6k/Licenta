import requests
import os
# from scopus.scopus_search import ScopusSearch

# Specify the API endpoint URL
url = 'https://api.elsevier.com/content/search/author'

# Specify your API key
# os.environ['SCOPUS_API_KEY']  = '4c0e89787f93c4ada1a98c82478950d3'
api_key = '12c5539128f88fab9d2f2f1a5e532b5a'
# Specify the search query

query = 'AUTHOR-NAME(Breaban Mihaela Elena)'
# query = 'TITLE-ABS-KEY("computer networks")'

# Specify the number of results to retrieve
count = 10

# Make a request to the API
response = requests.get(url, params={'query': query, 'count': count}, headers={'X-ELS-APIKey': api_key})

# Parse the JSON response
results = response.json()

# Extract information from the results...
print(results)









# results = ScopusSearch(query)

# Print the results
# print(results.results)