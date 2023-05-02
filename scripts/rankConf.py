import mysql.connector
import re 

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="scholar"
)

cursor = conn.cursor()

sql = "SELECT id, conference, year, rank FROM publications"
cursor.execute(sql)

publications = cursor.fetchall()

for pub in publications:
    id = pub[0]
    conference = pub[1]
    year = pub[2]
    rank = pub[3]
    match = re.search('\((.*?)\)', conference)
    if not match:
        continue
    acr = match.group(1)
    print("Publication id: " + str(id))
    print("Publication conference: " + conference)
    print(year)
    print(rank)

    acrDB = "SELECT acronym from conferences WHERE acronym = %s"
    cursor.execute(acrDB,(acr,))
    resAcr = cursor.fetchall()
    if not resAcr:
        continue

    print("Found")
    print(acr)
    sql = "SELECT rank, title, coreyear from conferences WHERE acronym = %s and RIGHT(coreyear,4) = %s"
    cursor.execute(sql,(acr,year,))

    results = cursor.fetchall()

    if not results:
        sqlYears = "(SELECT RIGHT(coreyear, 4) AS year_int, 'lower' AS proximity FROM conferences WHERE RIGHT(coreyear, 4) < %s ORDER BY year_int DESC LIMIT 1) UNION (SELECT RIGHT(coreyear, 4) AS year_int, 'higher' AS proximity FROM conferences WHERE RIGHT(coreyear, 4) > %s ORDER BY year_int ASC LIMIT 1);"
        cursor.execute(sqlYears,(year,year,))
        years = cursor.fetchall()
        print(years[0][0], years[1][0])

        sql = "SELECT max(rank_value), rank from conferences WHERE acronym = %s and (RIGHT(coreyear,4) = %s or RIGHT(coreyear,4) = %s)"
        if (int(year)-int(years[0][0]) == int(years[1][0])-int(year)):
            cursor.execute(sql,(acr,years[0][0],years[1][0],))
        elif (int(year)-int(years[0][0]) < int(years[1][0])-int(year)):
            cursor.execute(sql,(acr,years[0][0],years[0][0],))
        else:
            cursor.execute(sql,(acr,years[1][0],years[1][0],))

        results = cursor.fetchall()
        for result in results:
            print(result)
            update = "UPDATE publications SET rank = %s WHERE id = %s"
            cursor.execute(update,(result[1],id,))
            conn.commit()

    else:
    # Print the results
        for result in results:
            print(result)
            update = "UPDATE publications SET rank = %s WHERE id = %s"
            cursor.execute(update,(result[0],id,))
            conn.commit()

cursor.close()
conn.close()
# conference = "IEEE Congress on Evolutionary Computation (CEC)"
# acr = re.search('\((.*?)\)', conference).group(1)
# year = "2019"
# if year == "2010":
#     core = "ERA" + year
# else:
#     core = "CORE" + year


# 
# sql = "SELECT rank, title, coreyear from conferences WHERE acronym = %s and RIGHT(coreyear,4) = %s"
# cursor.execute(sql,(acr,year,))


# sql = '''SELECT MAX(rank), CONCAT('CORE', year) as coreyear
# FROM rankings
# WHERE CONCAT('CORE', year) IN ('CORE2015')
# GROUP BY CONCAT('CORE', year)

# UNION

# SELECT MAX(rank), CONCAT('CORE', year) as coreyear
# FROM rankings
# WHERE CONCAT('CORE', year) < 'CORE2015'
# AND CONCAT('CORE', year) IN (SELECT CONCAT('CORE', MAX(year)) FROM rankings WHERE CONCAT('CORE', year) < 'CORE2015')
# GROUP BY CONCAT('CORE', year)
# ORDER BY coreyear DESC
# LIMIT 2
# '''


# 
# results = cursor.fetchall()

# if not results:
#     sqlYears = "(SELECT RIGHT(coreyear, 4) AS year_int, 'lower' AS proximity FROM conferences WHERE RIGHT(coreyear, 4) < %s ORDER BY year_int DESC LIMIT 1) UNION (SELECT RIGHT(coreyear, 4) AS year_int, 'higher' AS proximity FROM conferences WHERE RIGHT(coreyear, 4) > %s ORDER BY year_int ASC LIMIT 1);"
#     cursor.execute(sqlYears,(year,year,))
#     years = cursor.fetchall()
#     print(years[0][0], years[1][0])

#     sql = "SELECT max(rank_value), rank from conferences WHERE acronym = %s and (RIGHT(coreyear,4) = %s or RIGHT(coreyear,4) = %s)"
#     cursor.execute(sql,(acr,years[0][0],years[1][0],))
#     results = cursor.fetchall()
#     for result in results:
#         print(result)
#         update = "UPDATE publications SET rank = %s WHERE id = %s"
#         cursor.execute(update,(result[1],id,))

# else:
# # Print the results
#     for result in results:
#         print(result)
#         update = "UPDATE publications SET rank = %s WHERE id = %s"
#         cursor.execute(update,(result[0],id,))


#years with core

# SELECT DISTINCT year FROM conferences
# WHERE year LIKE 'CORE%'
#   AND CAST(SUBSTR(year, 5) AS UNSIGNED) <= 2018
# ORDER BY CAST(SUBSTR(year, 5) AS UNSIGNED) DESC
# LIMIT 2