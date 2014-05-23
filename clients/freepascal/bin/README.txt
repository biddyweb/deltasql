Some notes on the deltaclient for Microsoft SQL server (22.5.2014 v1.7.0)
To get install instructions point your browser at http://deltasql.sourceforge.net/deltasql/manual.php#install-deltaclient-windows

Restart once
------------

If you want to test with the deltasql.sourceforge.net/deltasql instance, you need to restart at least once the deltaclient.

Hangup at startup
-----------------
If you are running behind a proxy and did not get the proxy parameter right at the first startup, deltasql hangs when running it the second time.
To fix the problem, you should run reset.bat, execute deltaclient.exe, hit the Settings button and set the correct proxy parameters.
Then, everything will work as expected.

Microsoft SQL server client
---------------------------

In order to work, you need to include a SQLCMD.exe client into this directory. You should take the SQLCMD.exe of your installation
located in C:\Program Files\Microsoft SQL Server\???\Tools\Binn\SQLCMD

The included SQLCMD.EXE is of Microsoft SQL server 2012 and is located in
C:\Program Files\Microsoft SQL Server\110\Tools\Binn\SQLCMD.exe
