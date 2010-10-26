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
echo "Performing continouus database integration on $dbtype"
echo "for project $project."
echo "(c) 2010 by HB9TVM and the deltasql team"
echo ""

# 2. retrieving and preparing version number
echo "Retrieving database schema version..."
./$dbtype/executescript.sh ./$dbtype/getversion.sql > ./$dbtype/rawversion.txt
./$dbtype/prepareversion.sh ./$dbtype/rawversion.txt ./$dbtype/version.txt
source ./$dbtype/version.txt
rm ./$dbtype/version.txt
timestamp=$(date)
dbversion="The database schema is at version $version on $timestamp"
echo "$dbversion"
echo "$dbversion" >> sync.log

# 3. asking deltasql server to generate synchronization script
./deltaclient.sh $version
./$dbtype/preparescript.sh ./syncscript.sql

# 4. executing generated script on database
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
echo "Finished on $timestamp2" >> sync.log
echo "" >> sync.log
rm syncscript.sql
echo "Results of this synchronization are appended to sync.log"
