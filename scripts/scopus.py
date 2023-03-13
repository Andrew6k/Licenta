import requests

# Specify the API endpoint URL
url = 'https://api.elsevier.com/content/search/scopus'

# Specify your API key
api_key = '4c0e89787f93c4ada1a98c82478950d3'

# Specify the search query

query = 'AUTHLASTNAME("Breaban") AND AUTHFIRST("Mihaela Elena")'
# query = 'TITLE-ABS-KEY("computer networks")'

# Specify the number of results to retrieve
count = 10

# Make a request to the API
response = requests.get(url, params={'query': query, 'count': count}, headers={'X-ELS-APIKey': api_key})

# Parse the JSON response
results = response.json()

# Extract information from the results...
print(results)
