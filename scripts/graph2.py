import numpy as np
import mysql.connector
import csv
import json
# import pickle
from sklearn.cluster import KMeans
import matplotlib.pyplot as plt

# Connect to the database and retrieve the citations data
cnx = mysql.connector.connect(host="localhost",
            user="root",
            password="",
            database="scholar")
cursor = cnx.cursor()
query = "SELECT  name, citations FROM authors where citations > 2"

cursor.execute(query)
citations = np.array(cursor.fetchall())
print (citations)

kmeans = KMeans(n_clusters=3)
kmeans.fit(citations[:,1].reshape(-1,1))
# print(kmeans)


labels = kmeans.predict(citations[:,1].reshape(-1,1))
print (labels)
print(citations[0][1])
print(len(labels))
# np.savetxt("array.txt",int(labels), delimiter= ",")
f = open("demo.txt", "a")
for label in labels:
    f.write(str(label)+',')


i=0
allData = []
for citation in citations:
    data = {"name": str(citation[0]), "citations": str(citation[1]), "cluster": str(labels[i])}
    # print(data)
    i = i + 1
    allData.append(data)

json_object = json.dumps(allData)
 
# Writing to sample.json
with open("sample.json", "w") as outfile:
    outfile.write(json_object)