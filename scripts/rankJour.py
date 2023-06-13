import mysql.connector
import re 

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="scholar"
)

cursor = conn.cursor()

sql = "SELECT id, conference, year, rank FROM publications WHERE rank = 'D'"
cursor.execute(sql)

publications = cursor.fetchall()

for pub in publications:
    id = pub[0]
    conference = pub[1]
    if conference is None:
        continue
    year = pub[2]
    rank = pub[3]
    # match = re.search('\((.*?)\)', conference)
    # if match:
    #     acr = match.group(1)
    
    print("Publication id: " + str(id))
    print("Publication conference: " + conference)
    print(year)
    print(rank)

    titleDB = """SELECT title, rank, year from journals where UPPER(title) LIKE %s and year = %s UNION
                SELECT title, rank, year
                FROM journals
                WHERE UPPER(title) LIKE %s
                AND year = (
                    SELECT MIN(year)
                    FROM journals
                    WHERE UPPER(title) LIKE %s
                )"""
    cursor.execute(titleDB,('%'+pub[1].upper()+'%',pub[2],'%'+pub[1].upper()+'%','%'+pub[1].upper()+'%',))
    resTitle = cursor.fetchall()

    if not resTitle:
        titleDB = """SELECT title, rank, year from journals_if where UPPER(title) LIKE %s and year = %s UNION
                SELECT title, rank, year
                FROM journals
                WHERE UPPER(title) LIKE %s
                AND year = (
                    SELECT MIN(year)
                    FROM journals_if
                    WHERE UPPER(title) LIKE %s
                )"""
        cursor.execute(titleDB,('%'+pub[1].upper()+'%',pub[2],'%'+pub[1].upper()+'%','%'+pub[1].upper()+'%',))
        resIF = cursor.fetchall()

        if not resIF:
            continue
        rankIF = resIF[0][1]
        update = "UPDATE publications SET rank = %s WHERE id = %s"
        cursor.execute(update,(rankIF,id,))
        conn.commit()
        

    else:
        rankAIS = resTitle[0][1]
        titleDB = """SELECT title, rank, year from journals_if where UPPER(title) LIKE %s and year = %s UNION
                SELECT title, rank, year
                FROM journals
                WHERE UPPER(title) LIKE %s
                AND year = (
                    SELECT MIN(year)
                    FROM journals_if
                    WHERE UPPER(title) LIKE %s
                )"""
        cursor.execute(titleDB,('%'+pub[1].upper()+'%',pub[2],'%'+pub[1].upper()+'%','%'+pub[1].upper()+'%',))
        resIF = cursor.fetchall()

        if not resIF:
            update = "UPDATE publications SET rank = %s WHERE id = %s"
            cursor.execute(update,(rankAIS,id,))
            conn.commit()
            continue

        rankIF = resIF[0][1]
        if rankAIS > rankIF:
            update = "UPDATE publications SET rank = %s WHERE id = %s"
            cursor.execute(update,(rankAIS,id,))
            conn.commit()
        else:
            update = "UPDATE publications SET rank = %s WHERE id = %s"
            cursor.execute(update,(rankIF,id,))
            conn.commit()
        
    # if not resTitle:
    #     if not resAcr:
    #         continue

    # if not resTitle:
    #     continue
    # if resTitle:
    #     acr = resTitle[0][0]
    #     print("Update" + acr)

    # print("Found")
    # print(acr)
    # sql = "SELECT rank, title, coreyear from conferences WHERE acronym = %s and RIGHT(coreyear,4) = %s"
    # cursor.execute(sql,(acr,year,))

    # results = cursor.fetchall()

    # if not results:
    #     sqlYears = "(SELECT RIGHT(coreyear, 4) AS year_int, 'lower' AS proximity FROM conferences WHERE RIGHT(coreyear, 4) < %s ORDER BY year_int DESC LIMIT 1) UNION (SELECT RIGHT(coreyear, 4) AS year_int, 'higher' AS proximity FROM conferences WHERE RIGHT(coreyear, 4) > %s ORDER BY year_int ASC LIMIT 1);"
    #     cursor.execute(sqlYears,(year,year,))
    #     years = cursor.fetchall()
    #     print(years[0][0], years[1][0])

    #     sql = "SELECT max(rank_value), rank from conferences WHERE acronym = %s and (RIGHT(coreyear,4) = %s or RIGHT(coreyear,4) = %s)"
    #     if (int(year)-int(years[0][0]) == int(years[1][0])-int(year)):
    #         cursor.execute(sql,(acr,years[0][0],years[1][0],))
    #     elif (int(year)-int(years[0][0]) < int(years[1][0])-int(year)):
    #         cursor.execute(sql,(acr,years[0][0],years[0][0],))
    #     else:
    #         cursor.execute(sql,(acr,years[1][0],years[1][0],))

    #     results = cursor.fetchall()
    #     for result in results:
    #         print(result)
    #         update = "UPDATE publications SET rank = %s WHERE id = %s"
    #         cursor.execute(update,(result[1],id,))
    #         conn.commit()

    # else:
    # # Print the results
    #     for result in results:
    #         print(result)
    #         update = "UPDATE publications SET rank = %s WHERE id = %s"
    #         cursor.execute(update,(result[0],id,))
    #         conn.commit()

cursor.close()
conn.close()
