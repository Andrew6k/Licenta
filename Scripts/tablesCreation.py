import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="scholar"
)

cursor = conn.cursor()

# table_create_query = """
# CREATE TABLE test (
#     id INT AUTO_INCREMENT PRIMARY KEY,
#     name VARCHAR(255),
#     age INT
# )
# """

table_create = """
CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    affiliation VARCHAR(255),
    email_domain VARCHAR(255),
    citations INT,
    mail VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    isadmin BOOLEAN DEFAULT 0
)
"""

cursor.execute(table_create)
conn.commit()

table_create = """
CREATE TABLE publications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    year YEAR,
    conference VARCHAR(255),
    summary VARCHAR(1000),
    citations INT
)
"""
cursor.execute(table_create)
conn.commit()


table_create = """
CREATE TABLE author_publications (
    author_id INT,
    publication_id INT,
    PRIMARY KEY (author_id, publication_id),
    FOREIGN KEY (author_id) REFERENCES authors(id),
    FOREIGN KEY (publication_id) REFERENCES publications(id)
)
"""

cursor.execute(table_create)
conn.commit()


table_create = """
CREATE TABLE domains (
    id INT AUTO_INCREMENT PRIMARY KEY,
    domain VARCHAR(255)
)
"""

cursor.execute(table_create)
conn.commit()

table_create = """
CREATE TABLE author_domains (
    author_id INT,
    domain_id INT,
    PRIMARY KEY (author_id, domain_id),
    FOREIGN KEY (author_id) REFERENCES authors(id),
    FOREIGN KEY (domain_id) REFERENCES domains(id)
)
"""

cursor.execute(table_create)
conn.commit()

cursor.close()
conn.close()