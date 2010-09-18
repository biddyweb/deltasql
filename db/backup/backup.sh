#!/bin/sh
# This is a backup script for your deltasql data
# that copies deltasql dumps each day
# (if correctly configured with crontab -e)
# on a Windows server \\yourserver on which  a directory
# structure deltasql\lastDay and deltasql\lastMonth exists.
EXT1=$(date +\%H).sql.gz
EXT2=$(date +\%d).$EXT1
FILENAME=dump$(date +\%Y\%m)$EXT2
rm dump*.sql.gz
mysqldump --user deltauser -pdeltapass deltasql | gzip > $FILENAME
# copy to last day backupscripts, remove old script
smbclient '\\yourserver' -U youruser%yourpassword -c 'cd deltasql\lastDay; rm *'$EXT1'; put '$FILENAME >> backup.log 2>&1

# these does not work for some reason :-#
#copy the dayly backup to the mothly backups
#if [ $EXT1 = "01.sql.gz" ]; then
#  smbclient '\\yourserver' -U youruser%yourpassword -c 'cd deltasql\lastMonth; rm *'$EXT2'; put '$FILENAME >> backup.log 2>&1
#fi
rm $FILENAME
