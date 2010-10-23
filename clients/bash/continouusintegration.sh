#!/bin/bash
# This script can be used in a cron job to perform continouus 
# database integration. 

# 1. reading configuration file
source deltasql.conf

# 2. retrieving and preparing version number
./$dbtype/executescript.sh ./$dbtype/getversion.sql > ./$dbtype/rawversion.txt
./$dbtype/prepareversion.sh ./$dbtype/rawversion.txt ./$dbtype/version.txt
source ./$dbtype/version.txt
rm ./$dbtype/version.txt
dbversion="The database schema is at version $version"
echo "$dbversion"
echo "$dbversion" >> sync.log

# 3. asking deltasql server to generate synchronization script
./deltaclient.sh $version

# 4. executing generated script on database
./$dbtype/executescript.sh ./syncscript.sql &> sync.tmp.log

# 5. cleaning up logfiles
cat sync.tmp.log >> sync.log
rm sync.tmp.log
mv syncscript.sql syncscript.log
echo "Finished" >> sync.log
echo "" >> sync.log
