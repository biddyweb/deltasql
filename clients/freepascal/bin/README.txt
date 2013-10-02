Some notes on the deltaclient (06.4.2013 v1.6.0)
To get install instructions point your browser at http://deltasql.sourceforge.net/deltasql/manual.php#install-deltaclient-windows

Restart once
------------

If you want to test with the deltasql.sourceforge.net/deltasql instance, you need to restart at least once the deltaclient.

Hangup at startup
-----------------
If you are running behind a proxy and did not get the proxy parameter right at the first startup, deltasql hangs when running it the second time.
To fix the problem, you should run reset.bat, execute deltaclient.exe, hit the Settings button and set the correct proxy parameters.
Then, everything will work as expected.

Using deltaclient with deltasql server prior than 1.4.0
-------------------------------------------------------
If you want to use the deltaclient with server versions previous than 1.4.0 (but greater than 1.3.1), you could take the two files dbsync_list_branches.php and
dbsync_list_projects.php and copy them into your current productive environment. These two files are additional interfaces needed by deltaclient in order to run properly.


Please report problems with the client at gpu-world at lists.sourceforge.net
Thank you!
