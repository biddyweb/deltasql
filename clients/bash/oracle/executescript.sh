#!/bin/bash
source ./deltasql.conf
sqlplus $username/$password@$sid @$1
