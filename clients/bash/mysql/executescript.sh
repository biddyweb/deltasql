#!/bin/bash
source ../deltasql.conf
mysql -h localhost -u root -p -D deltasql --skip-column-names getversion.sql 
