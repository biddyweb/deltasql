#!/bin/bash
# Simple deltasql client (c) by 2010 HB9TVM and the deltasql team
# Input: arg1: current version of database schema
# Output: file syncscript.sql , a synchronization script for the db schema
# all other options are set into deltasql.conf

function is_integer() {    
   s=$(echo $1 | tr -d 0-9)
   if [ -z "$s" ]; then        
      return 0    
   else        
      return 1    
   fi
}


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
if is_integer $1; then
  msg="Retrieving current version from $urldeltasql ..."
  echo $msg
  echo $msg >> sync.log
else
  errormsg="$1 is not an integer! Please check the database connection and parameters in deltasql.conf!"
  echo $errormsg
  echo $errormsg >> sync.log
  exit 0
fi
wget -q "$urldeltasql/dbsync_automated_currentversion.php?project=$project" -O version.txt
version=`grep -i "project.version" version.txt | sed 's/^.* = //'`
rm version.txt


if [ -z $version ]; then
   errormsg="Could not retrieve project version from URL above!"
   echo $errormsg
   echo $errormsg >> sync.log
   exit 0
fi

if is_integer $version; then
   projectversion="Project $project is at version $version."
   echo $projectversion
   echo $projectversion >> sync.log
else
   $errormsg="Version retrieved from deltasql is not integer, please check connection to deltasql and parameters in deltasql.conf!"
   echo $errormsg 
   echo $errormsg >> sync.log
   exit 0
fi

if [ $1 -ge $version ]; then
    msg="This schema is already uptodate ($1>=$version). Nothing to do."
    echo $msg
    echo $msg >> sync.log
    exit 0
fi


echo "Asking deltasql to generate script..."
wget -q "$urldeltasql/dbsync_automated_update.php?project=$project&version=$1&frombranch=$from&tobranch=$to" -O syncscript.sql
echo "Script syncscript.sql created succesfully."

