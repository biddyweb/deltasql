#!/usr/bin/python
import MySQLdb
import SimpleConfigParser
import urllib

# opening configuration file
cp = SimpleConfigParser.SimpleConfigParser()
cp.read('config.ini')

# First we retrieve the current version from the database schema
db=MySQLdb.connect(cp.getoption('host'),cp.getoption('username'),
                   cp.getoption('password'),cp.getoption('database'))

c=db.cursor()
c.execute('select versionnr from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);')
ver=c.fetchone()
db.close()
versionnr= ver[0]
print "Database schema is currently at version "+str(versionnr)+"."

# We check the current version on the external deltasql server
wwwurl = cp.getoption('url')+'/dbsync_automated_currentversion.php?project='+cp.getoption('project')
serverUrl = urllib.urlopen(wwwurl)
f = open('project.properties', 'wb')
f.write(serverUrl.read())
f.close()
pp = SimpleConfigParser.SimpleConfigParser()
pp.read('project.properties')
srvversionnr=pp.getoption('project.version')
print "On deltasql server, project "+cp.getoption("project")+" is at version "+str(srvversionnr)+"."
if (srvversionnr<=versionnr):
	print "Nothing to do for the moment. Exiting..."
else:
	print "Downloading synchronization script from server..."




