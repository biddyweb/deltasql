#!/bin/bash
cp *.php ../../
cp ../manual.php ../
cp ../faq.php ../
chmod 755 ../../*.php

mkdir ../../pictures
chmod 755 ../../pictures
cp ../pictures/* ../../pictures

mkdir ../../docs
chmod 755 ../../docs
cp ../docs/* ../../docs

#mkdir ../../utils
#chmod 755 ../../pictures
cp ../utils/constants.inc.php ../../utils
cp ../utils/utils.inc.php ../../utils
cp ../utils/timing.inc.php ../../utils
