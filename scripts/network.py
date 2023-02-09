import networkx as nx
import pandas as pd
import mysql.connector
import matplotlib.pyplot as plt

cnx = mysql.connector.connect(host="localhost",
            user="root",
            password="",
            database="scholar")
cursor = cnx.cursor()
query = "SELECT  * FROM author_publications "

cursor.execute(query)
data=cursor.fetchall()

edges = []
for row in data:
    edges.append((row[0], row[1]))

# Create the graph using NetworkX
G = nx.Graph()
G.add_edges_from(edges)

# Draw the graph
nx.draw(G)

plt.show()