import mysql.connector

def db_mysql_retrieve_info(mysql_host, mysql_username, mysql_password, mysql_database):
    # First we retrieve the current version from the database schema
    try:
        cnx = mysql.connector.connect(user=mysql_username, password=mysql_password,
                              host=mysql_host,
                              database=mysql_database)
        cursor = cnx.cursor()
        query = ("select versionnr, projectname, branchname from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);")
        cursor.execute(query)
        myres = cursor.fetchone()
        cursor.close()
        cnx.close()
        
        versionnr=myres[0]
        projectname=myres[1]
        branchname=myres[2]
        
        return versionnr, projectname, branchname
    except:
        print "ERROR: Could not connect to mySQL database through Oracle's mysql.connector adapter, please check connection settings in config.ini"
        exit(1)