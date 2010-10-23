#!/bin/bash
# Simple deltasql client (c) by 2010 HB9TVM
# Input: arg1: current version of database schema
# Output: file syncscript.sql , a synchronization script for the db schema
# all other options are set into deltasql.conf

if [ -z "$1" ]; then 
  echo ""  
  echo "       deltasql bash client (c) by 2010 HB9TVM"   
  echo ""
  echo "  Please retrieve the database schema version number with"   
  echo "  select * from TBSYNCHRONIZE where versionnr = "
  echo "                   (select max(versionnr) from TBSYNCHRONIZE);"
  echo "  and launch ./deltaclient.sh [versionnr]"
  exit 0
fi
  
# reading configuration options
source deltasql.conf

# retrieving current version from deltasql
echo "Retrieving current version from $urldeltasql ..."
wget -q "$urldeltasql/dbsync_automated_currentversion.php?project=$project" -O version.txt
cat version.txt | grep -i "project.version" > version.txt
cat version.txt | cut -c 9- > version.txt
cat version.txt | sed s/" = "/"="/ > version.txt
source version.txt
rm version.txt

projectversion="Project $project is at version $version."
echo $projectversion
echo $projectversion >> sync.log

if [ $1 -ge $version ]; then
    echo "This schema is already uptodate. Nothing to do."
    exit 0
fi


echo "Asking deltasql to generate script..."
wget -q "$urldeltasql/dbsync_automated_update.php?project=$project&version=$1&frombranch=$from&tobranch=$to" -O syncscript.sql
echo "Script syncscript.sql created succesfully."

