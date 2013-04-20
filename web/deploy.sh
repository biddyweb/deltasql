#!/bin/bash
cp *.php ../../
cp manual.php ../
cp faq.php ../
chmod 755 ../../*.php
mkdir ../../utils
cp ../utils/constants.inc.php ../../utils
cp ../utils/utils.inc.php ../../utils
cp ../utils/timing.inc.php ../../utils
