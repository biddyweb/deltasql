#!/bin/bash
# This script can be used in a cron job to perform continouus 
# database integration. 
source deltasql.conf
./$dbtype/executescript.sh ./$dbtype/getversion.sql > ./$dbtype/version.txt
./deltaclient.sh < ./$dbtype/version.txt
