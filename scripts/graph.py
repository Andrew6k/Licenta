import numpy as np
import mysql.connector
import csv
# import pickle
from sklearn.cluster import KMeans
import matplotlib.pyplot as plt

# Connect to the database and retrieve the citations data
cnx = mysql.connector.connect(host="localhost",
            user="root",
            password="",
            database="scholar")
cursor = cnx.cursor()
query = "SELECT  citations FROM authors where citations > 2"

cursor.execute(query)
citations = cursor.fetchall()


# Convert the citation data into a numpy array
citations = np.array(citations)

# Perform k-means clustering on the citation data
k = 3  # number of clusters
kmeans = KMeans(n_clusters=k)
kmeans.fit(citations)

# Get the cluster labels for each author
labels = kmeans.labels_

print(labels)

# Convert the data into a numpy array
# citations_array = np.array(citations)
# print(citations_array)

# Perform k-means clustering
# kmeans = KMeans(n_clusters=3).fit(citations_array)

# Save the result
# np.savetxt("kmeans_result.txt", kmeans.labels_, delimiter=",")
# labels = kmeans.predict(citations[:,1].reshape(-1,1))
# with open('author_citations.csv', 'w', newline='') as file:
#     writer = csv.writer(file)
#     writer.writerows(kmeans)

# Close the connection to the database
# conn.close()
# cursor.execute(query)
# citations = np.array(cursor.fetchall())

# # Create the k-means model
# kmeans = KMeans(n_clusters=3)
# kmeans.fit(citations[:,1].reshape(-1,1))
# # kmeans.fit(citations)

# # Predict the cluster for each author
# # labels = kmeans.predict(citations[:,1].reshape(-1,1))

# np.savetxt("kmeans_result.txt", kmeans.cluster_centers_, delimiter=",")

# cnx.close()

# # Plot the results
# # plt.scatter(citations[:,0], citations[:,1], c=labels)
# # plt.xlabel("Author ID")
# # plt.ylabel("Citations")
# # plt.show()
