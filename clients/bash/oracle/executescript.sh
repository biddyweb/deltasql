#!/bin/bash
source ./deltasql.conf
sqlplus $username/$password@$tnsname @$1
