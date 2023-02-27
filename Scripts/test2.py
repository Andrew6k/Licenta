# import re

# str = '2015 IEEE 27th International Conference on Tools with Artificial, 1-13'
# str = str.replace('-','')
# str = str.replace(',','')
# words = str.split(" ")
# str2 = ''
# for word in words:
#     if not word.isnumeric() :
#         if str2 == '':
#             str2 = word
#         else:
#             str2 = str2 + ' ' + word
# print(str2)

# str2 = re.sub(r'[\d,-]+', '', str)
# print(str2)

# for i in range(10,15):
#     print(i)
#     for j in range(0,4):
#         if j % 2 == 0:
#             break
#         print(j)





# import mysql.connector

# try:
#     conn = mysql.connector.connect(
#         host="localhost",
#         user="root",
#         password="",
#         database="scholar"
#         )
# except:
#     print("Database not available!")
# # cursor = conn.cursor()
# else:
#     print("works")


# from cryptography.fernet import Fernet

# keyF = Fernet.generate_key()
# print(keyF)
# fernet = Fernet(keyF)
# enc = fernet.encrypt("hello".encode())
# print(enc)

# dec = fernet.decrypt(enc).decode()
# print(dec)

import mysql.connector


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
        # sql = "SELECT name from authors"
        cursor.execute("SELECT title, id FROM publications")

#         # Fetch the first row of the result set
        results = cursor.fetchall()

#         # Print the first row
        for row in results:
            value = [row[1]]
            insert_query = f"""
                    SELECT name from authors join author_publications on author_id = authors.id where publication_id = %s
                    """
            cursor.execute(insert_query, (row[1],))
            authors = cursor.fetchall()
            print(row[0])
            for author in authors:
                   print(author[0])
            print("-------")

#         # Close the cursor and connection
        cursor.close()
        conn.close()
# import sys
# sys.argv[1] = sys.argv[1].replace('-',' ')
# print(sys.argv[1])



# data = {}
# data["authors"] = []
# data["pub"] = []
# data["domains"] = []
# data["authD"] = []

# with open("output.txt", "r") as f:
#     # Iterate over the lines of the file
#     for line_number, line in enumerate(f, start=1):
#         # Check if the string is present in the line
#         if "" in line:
#             print("Search string found in line", line_number, ":", line.strip())
            
#     else:
#         print("Search string not found in file.")