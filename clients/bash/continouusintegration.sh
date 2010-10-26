#!/bin/bash
# This bash script can be used in a cron job to perform continouus 
# database integration. 
# It retrieves first the current schema version. With this information
# it asks the deltasql server for a SQL synchronization script.
# It executes the SQL synchronization script back into the database.
# 
# (c) 2010 HB9TVM and the deltasql Team 

# 1. reading configuration file
source deltasql.conf
echo "" >> sync.log
echo "Performing continouus database integration on $dbtype for project $project"
echo "(c) 2010 by HB9TVM and the deltasql team"
echo ""

# 2. retrieving and preparing version number
timestamp=$(date)
msg="$timestamp ... retrieving database schema version..."
echo $msg 
echo $msg >> sync.log
./$dbtype/executescript.sh ./$dbtype/getversion.sql > ./$dbtype/rawversion.txt
./$dbtype/prepareversion.sh ./$dbtype/rawversion.txt ./$dbtype/version.txt
source ./$dbtype/version.txt
rm ./$dbtype/version.txt
dbversion="The database schema is at version $version."
echo "$dbversion"
echo "$dbversion" >> sync.log

# 3. asking deltasql server to generate synchronization script
if [ -f ./syncscript.sql ]
then
   rm ./syncscript.sql
   echo "File synscript.sql exists! Removing it." >> sync.log
fi 
./deltaclient.sh $version
if [ ! -f ./synscript.sql ]
then
   msg="No synchronization script generated."
   echo $msg
   echo $msg >> sync.log
   exit 0
fi



# 4. executing generated script on database
./$dbtype/preparescript.sh ./syncscript.sql
./$dbtype/executescript.sh ./syncscript.sql &> sync.tmp.log
echo "Script executed and added to syncscript.log"

# 5. cleaning up logfiles
cat sync.tmp.log >> sync.log
rm sync.tmp.log
echo "" >> syncscript.log
echo "-- *************************************************************" >> syncscript.log
echo "-- * Upgrading from version $version on $timestamp" >> syncscript.log
echo "-- *************************************************************" >> syncscript.log
cat syncscript.sql >> syncscript.log
timestamp2=$(date)
echo "$timestamp2 Database synchronization finished." >> sync.log
echo "" >> sync.log
rm syncscript.sql
echo "Results of this synchronization are appended to sync.log"
