#!/usr/bin/python
# (c) 2012-2013 HB9TVM and the deltasql team
# Please open and edit config.ini to configure this Python deltasql client
from dbadapter import db_retrieve_info
import SimpleConfigParser
import urllib
import os

# some initial clenaup steps
if os.path.exists('project.properties'): os.unlink('project.properties')
if os.path.exists('script.sql'): os.unlink('script.sql')
if os.path.exists('script.out'): os.unlink('script.out')

# opening configuration file
cp = SimpleConfigParser.SimpleConfigParser()
cp.read('config.ini')

versionnr, projectname, branchname = db_retrieve_info(cp.getoption('host'),cp.getoption('username'),
                                     cp.getoption('password'),cp.getoption('database'))

print "Database schema for project "+projectname+" is currently at version "+str(versionnr)+" and follows branch "+branchname+"."

# Checking our data with the configuration script
if projectname!=cp.getoption('project'):
	print "ERROR: Project in config.ini ("+cp.getoption('project')+") does not match project on database schema!"
	exit(1)
if branchname!=cp.getoption('frombranch'):
	print "ERROR: frombranch option in config.ini ("+cp.getoption('frombranch')+") does not match branch on database schema!"
	exit(1)


# We check the current version on the external deltasql server
try:
	versionurl = cp.getoption('url')+'/dbsync_automated_currentversion.php?project='+urllib.quote(cp.getoption('project'))
	versionpage = urllib.urlopen(versionurl)
except:
	print "ERROR: could not access "+cp.getoption('url')+" Please verify your settings in config.ini and make sure you have access to this URL..."
	exit(1)

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
        scripturl = cp.getoption('url')+'/dbsync_automated_update.php?project='+urllib.quote(cp.getoption('project'))+'&version='+str(versionnr)+'&frombranch='+urllib.quote(cp.getoption('frombranch'))+'&tobranch='+urllib.quote(cp.getoption('tobranch'))+'&dbtype=mySQL'
	
	try:
		scriptpage = urllib.urlopen(scripturl)
        	f = open('script.sql', 'wb')
        	f.write(scriptpage.read())
        	f.close()
		print('Synchronization script downloaded :-)');
	except:
		print('ERROR: could not download synchronization script. Is the connection unstable?')
		exit(1)

	# now depending on executeupdate
	if (cp.getoption('executeupdate')=='no'):
	        # we either show the script to the user
                print('Showing script to the user with '+cp.getoption('opencommand')+' script.sql &')
		os.system(cp.getoption('opencommand')+' script.sql &')
	elif (cp.getoption('executeupdate')=='yes'):
		#or we execute it directly into the database
                command=cp.getoption('synccommand')+' --host "'+cp.getoption('host')+'" --user "'+cp.getoption('username')+'" -p'+cp.getoption('password')+' --database "'+cp.getoption('database')+'" < script.sql &> script.out'

                print('Executing script.sql into database schema')
                print command   
     		os.system(command)
		print "Output of synchronization script stored in script.out is:"
		os.system('cat script.out')	
		print "The concatenated output of all executions is stored in fullscript.out"
		os.system('cat script.out >> fullscript.out')	
	else:
		print('ERROR: unrecognized executeupdate option in config.ini')
		exit(1)
		
print "Done!"
exit(0)



