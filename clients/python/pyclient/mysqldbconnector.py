import MySQLdb

def db_mysql_retrieve_info(mysql_host, mysql_username, mysql_password, mysql_database):
    # First we retrieve the current version from the database schema
    try:
        db=MySQLdb.connect(mysql_host, mysql_username, mysql_password, mysql_database)

        c=db.cursor()
        c.execute('select versionnr, projectname, branchname from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);')
        qtuple= c.fetchone()
        versionnr=qtuple[0]
        projectname=qtuple[1]
        branchname=qtuple[2]
        db.close()
        
        return versionnr, projectname, branchname
    except:
        print 'ERROR: Could not connect to mySQL database through MySQLdb adapter, please check connection settings in config.ini'
        exit(1)