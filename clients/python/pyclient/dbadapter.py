import SimpleConfigParser

cp = SimpleConfigParser.SimpleConfigParser()
cp.read('config.ini')
pyadaptoption = cp.getoption('pydbadapter')
if   pyadaptoption=="mysqlconnector":
    from oraclemysqlconnector import db_mysql_retrieve_info
elif pyadaptoption=="MySQLdb":
    from mysqldbconnector import db_mysql_retrieve_info
else:
    print "ERROR in config.ini, pydbadapter option is unrecognized"   

def db_retrieve_info(host, username, password, database):
    # opening configuration file
    versionnr, projectname, branchname = db_mysql_retrieve_info(host, username, password, database)
    return versionnr, projectname, branchname