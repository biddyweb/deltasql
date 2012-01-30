#!/bin/bash
cp index.php ./deltasql/web
cd deltasql
git commit -a -m "homepage update"
git push
cd ..
