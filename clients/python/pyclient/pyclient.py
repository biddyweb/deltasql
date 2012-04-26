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
print "Database schema is currently at version "+str(versionnr)

# We check the current version on the external deltasql server

wwwurl = cp.getoption('url')+'/dbsync_automated_currentversion.php?project='+cp.getoption('project')
print wwwurl

serverUrl = urllib.urlopen(wwwurl)
properties= serverUrl.read()
print properties

