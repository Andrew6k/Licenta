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
# Add nodes to the graph
G.add_edges_from(edges)
# Get the list of all authors and publications
authors = [node for node, degree in G.degree if degree > 1]
publications = [node for node, degree in G.degree if degree == 1]
# Set the color for each node
node_colors = []
for node in G.nodes:
    if node in authors:
        node_colors.append('red')
    elif node in publications:
        node_colors.append('blue')
# Draw the graph
nx.draw(G, node_color=node_colors)
plt.show()