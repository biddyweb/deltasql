#!/bin/bash
sed -i -e 's_.*_version=&_' $1
mv $1 $2
