<center>
<table border="1">
<tr><th>client</th><th>help</th><th>environment</th><th>description</th><th>version</th><th>actions</th></tr>
<tr><td><b>deltaclient</b></td><td><a href="manual.php#install-deltaclient-windows"><img src="icons/help.png"></a></td><td>Windows (Freepascal)</td><td>Multipurpose deltasql client written in Freepascal (for Windows XP, Vista, 7).
 It directly retrieves available projects and branches from server and allows only valid project/branches combinations. It copies the generated script to clipboard and shows it in the editor of choice. However, the script can not be automatically executed in the database, but needs to be copy&pasted.</td><td><?php echo "$deltaclient_windows_version"; ?></td><td><a href="clients/freepascal/deltaclient_windows.zip"><center>download...</center></a></td></tr>

<tr><td><b>deltaclient</b></td><td><a href="manual.php#install-deltaclient-linux"><img src="icons/help.png"></a></td><td>Linux (Freepascal)</td><td>Multipurpose deltasql client written in Freepascal (for Linux). It is the client explained on the line above, but compiled for Linux on the x86 architecture. Works on Ubunty Unity and on Debian Gnome.</td><td><?php echo "$deltaclient_linux_version"; ?></td><td><a href="clients/freepascal/deltaclient_linux_unity.tar.gz"><center>for Unity...</center></a><br>
<a href="clients/freepascal/deltaclient_linux_gnome.tar.gz"><center>for Gnome...</center></a>
</td></tr>

<tr><td><b>ant-client</b></td><td><a href="manual.php#install-ant-client"><img src="icons/help.png"></a></td><td>Eclipse (Ant)</td><td>Lightweight, retrieves version directly from db schema and shows synchronization script from deltasql server (for MySQL, PostgreSQL, Oracle, MS SQL Server and Sybase). The JDBC driver is not included, but can be retrieved from the dbredactor client.</td><td><?php echo "$antclient_version"; ?></td><td><a href="clients/java/ant-client.zip"><center>download...</center></a></td></tr>

<tr><td><b>bash client</b></td><td><a href="manual.php#install-bash"><img src="icons/help.png"></a></td><td>GNU/Linux (bash)</td><td>This Bash script can be 
used to achieve continouus integration for
 database schemas on a Linux server if scheduled with a cron job (for 
MySQL, PostgreSQL and Oracle). The synchronization script is automatically executed into the database schema.</td><td><?php echo 
"$bashclient_version" 
?></td><td><center><a 
href="clients/bash_client.tar.gz">download...</a></center></td></tr>

<tr><td><b>dbredactor</b></td><td><a href="manual.php#install-dbredactor-client"><img src="icons/help.png"></a></td><td>Eclipse (Java, Ant)</td><td>Retrieves version directly from db schema and shows synchronization script from deltasql server (for MySQL, PostgreSQL, Oracle, Sybase, sqlite and MS SQL Server). JDBC driver is included.</td><td><?php echo "$dbredactor_version"; ?></td><td><a href="clients/java/dbredactor.zip"><center>download...</center></a></td></tr>

<tr><td><b>pyclient</b></td><td><a href="manual.php#install-pyclient"><img src="icons/help.png"></a></td><td>Python (Linux)</td><td>This simple Python script retrieves version directly from db schema and shows synchronization script from deltasql server or executes it into schema depending on configuration (for MySQL only, either through MySQLdb adapter or through Oracle's mysql.connector). </td><td><?php echo "$pyclient_version"; ?></td><td><a href="clients/python/pyclient.tar.gz"><center>download...</center></a></td></tr>
</table>
</center>
