#!/bin/bash
tar -cf /cygdrive/d/xampp/htdocs/deltasql-backup.tar /cygdrive/d/xampp/htdocs/deltasql
gzip /cygdrive/d/xampp/htdocs/deltasql-backup.tar
mv /cygdrive/d/xampp/htdocs/deltasql-backup.tar.gz /cygdrive/d/Backups/deltasql
echo "Backup finished :-)"