Darko Bunic
http://www.redips.net/php/from-mysql-to-xml/
http://www.redips.net/php/from-mysql-to-html-with-xml/
January 2009.

February 2012.
- code beautified
- php short tags replaced with <?php
- fixed bug in "if" case (operator should be "!==" and not "!=")


These examples show the dynamic creation of XML from MySQL database using PHP.

Before running tests:

1) Should have MySQL ver.4+ and PHP ver.5+

2) Create MySQL database "test"
mysql> create database test;

3) Create two tables in "test" database
bash> mysql -p test < database.sql

4) Make sure you have installed php-xml package (not needed for Example 1)
bash> yum install php-xml

5) set MySQL username and password in sql2xml.php line 12
First parameter "localhost" will be fine in most cases so you don't have to change it. 



Example 1: MySQL -> XML
from command line run: php test1.php

files needed:
sql2xml.php
test1.php

http://www.redips.net/php/from-mysql-to-xml/


Example 2: MySQL -> XML -> HTML
from command line run: php test2.php

files needed:
sql2xml.php
xsl.php
test2.php
test2.xsl

http://www.redips.net/php/from-mysql-to-html-with-xml/

If you place this scripts in document root of your LAMP server, then you can run test1.php and test2.php with browser.
You will see in case of test1.php how XML will be nicely indented.


I hope my scripts will be useful for you.
Darko
