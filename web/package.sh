#!/bin/bash
# This script is used to package a new deltasql release
# script has one parameter, the deltasql version number
cp -r deltasql "deltasql-$1"
cd "deltasql-$1"
rm -rf .git
cd conf
rm config.inc.php
cd ..
cd ..
tar -cf "deltasql-$1.tar" "./deltasql-$1"
gzip "deltasql-$1.tar"
chmod 755 "deltasql-$1.tar.gz"
rm -rf "./deltasql-$1"

