#!/usr/bin/python
import MySQLdb
import SimpleConfigParser
import urllib
import os

# some initial clenaup steps
if os.path.exists('project.properties'): os.unlink('project.properties')
if os.path.exists('script.sql'): os.unlink('script.sql')


# opening configuration file
cp = SimpleConfigParser.SimpleConfigParser()
cp.read('config.ini')

# First we retrieve the current version from the database schema
try:
	db=MySQLdb.connect(cp.getoption('host'),cp.getoption('username'),
        	           cp.getoption('password'),cp.getoption('database'))

	c=db.cursor()
	c.execute('select versionnr, projectname, branchname from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);')
	qtuple= c.fetchone()
	versionnr=qtuple[0]
	projectname=qtuple[1]
	branchname=qtuple[2]
	db.close()
except:
	print 'ERROR: Could not connect to mySQL database, please check connection settings in config.ini'
	exit(0)

print "Database schema for project "+projectname+" is currently at version "+str(versionnr)+" and follows branch "+branchname+"."

# Checking our data with the configuration script
if projectname!=cp.getoption('project'):
	print "ERROR: Project in config.ini ("+cp.getoption('project')+") does not match project on database schema!"
	exit(0)
if branchname!=cp.getoption('frombranch'):
	print "ERROR: frombranch option in config.ini ("+cp.getoption('frombranch')+") does not match branch on database schema!"
	exit(0)


# We check the current version on the external deltasql server
try:
	versionurl = cp.getoption('url')+'/dbsync_automated_currentversion.php?project='+cp.getoption('project')
	versionpage = urllib.urlopen(versionurl)
except:
	print "ERROR: could not access "+cp.getoption('url')+" Please verify your settings in config.ini and make sure you have access to this URL..."
	exit(0)

f = open('project.properties', 'wb')
f.write(versionpage.read())
f.close()
pp = SimpleConfigParser.SimpleConfigParser()
pp.read('project.properties')
srvversionnr=pp.getoption('project.version')
if os.path.exists('project.properties'): os.unlink('project.properties')

print "On deltasql server, project "+cp.getoption("project")+" is at version "+str(srvversionnr)+"."
if (srvversionnr<=versionnr):
	print "Nothing to do for the moment. Exiting..."
else:
	print "Downloading synchronization script from server..."
        scripturl = cp.getoption('url')+'/dbsync_automated_update.php?project='+cp.getoption('project')+'&version='+str(versionnr)+'&frombranch='+cp.getoption('frombranch')+'&tobranch='+cp.getoption('tobranch')+'&dbtype=mySQL'
	
	scriptpage = urllib.urlopen(scripturl)
        f = open('script.sql', 'wb')
        f.write(scriptpage.read())
        f.close()
	print('Synchronization script downloaded :-)');




