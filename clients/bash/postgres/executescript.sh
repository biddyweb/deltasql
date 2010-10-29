#!/bin/bash
source ./deltasql.conf
psql -h $host -p $port -U $username -d $database -q -t -f $1
