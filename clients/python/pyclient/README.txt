To get the deltasql pyclient running, you need either the connector MySQLdb or Oracle's mysql connector. To choose the connector you installed, configure the variable
pydbadapter in config.ini

To install Oracle mysql.connector visit http://dev.mysql.com/downloads/connector/python/
If you prefer to install MySQLdb visit http://sourceforge.net/projects/mysql-python/
Your favourite Linux distribution might have them as preconfigured packages.

To start, please edit the configuration file config.ini with your settings. Launch the Python client with ./pyclient.py once you made everything executable with 
chmod 755 *.py

More info on how to install and use the Python client at
http://deltasql.sourceforge.net/deltasql/manual.php#install-pyclient

Final Note: the unit SimpleConfigParser.py is copyright by Philippe Lagadec
