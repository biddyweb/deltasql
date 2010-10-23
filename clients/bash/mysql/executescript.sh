#!/bin/bash
source ../deltasql.conf
mysql -h $host -u $username -p$password -D $database --skip-column-names -e "source $1"
