<h3>Download deltasql clients</h3>
<p>
Instead of manually synchronizing with the <a href="dbsync.php">form</a> in the synchronization section on the server, you might want
to try out one of the clients that connect to this server and which integrate into your development environment: 
</p>
<center>
<table border="1">
<tr><th>client</th><th>help</th><th>environment</th><th>description</th><th>version</th><th>actions</th></tr>
<tr><td><b>deltaclient</b></td><td><a href="manual.php#install-deltaclient"><img src="icons/help.png"></a></td><td>Windows (Freepascal)</td><td>Multipurpose deltasql client written in Freepascal for Windows (XP, Vista, 7).
 It directly retrieves available projects and branches from server. It copies the generated script to clipboard and shows it in the editor of choice. 
 Source could be compiled also for other architectures.</td><td><?php echo "$deltaclient_version"; ?></td><td><a href="clients/freepascal/deltaclient.zip"><center>download...</center></a></td></tr>
<tr><td><b>ant-client</b></td><td><a href="manual.php#install-ant-client"><img src="icons/help.png"></a></td><td>Eclipse (Ant)</td><td>Lightweight, retrieves version directly from db schema and shows synchronization script from deltasql server (for MySQL, PostgreSQL, Oracle, MS SQL Server and Sybase). JDBC driver not included.</td><td><?php echo "$antclient_version"; ?></td><td><a href="clients/java/ant-client.zip"><center>download...</center></a></td></tr>
<tr><td><b>bash client</b></td><td><a href="manual.php#install-bash"><img src="icons/help.png"></a></td><td>GNU/Linux (bash)</td><td>This Bash script can be 
used to achieve continouus integration for
 database schemas on a Linux server if scheduled with a cron job (for 
MySQL, PostgreSQL and Oracle).</td><td><?php echo 
"$bashclient_version" 
?></td><td><center><a 
href="clients/bash_client.tar.gz">download...</a></center></td></tr>
<tr><td><b>dbredactor</b></td><td><a href="manual.php#install-dbredactor-client"><img src="icons/help.png"></a></td><td>Eclipse (Java, Ant)</td><td>Retrieves version directly from db schema and shows synchronization script from deltasql server (for MySQL, PostgreSQL, Oracle, MS SQL Server and Sybase). JDBC driver included.</td><td><?php echo "$dbredactor_version"; ?></td><td><a href="clients/java/dbredactor.zip"><center>download...</center></a></td></tr>
<tr><td><b>latest scripts</b></td><td><a href="manual.php#install-google-gadget"><img src="icons/help.png"></a></td><td>Google Gadget</td><td>Shows latest scripts on your server on iGoogle start page.</td><td><?php echo "$gadget_version"; ?></td><td><a href="http://www.google.ch/ig/adde?hl=en&moduleurl=http://www.gpu-grid.net/deltasql/deltasql_google_gadget.xml&source=imag" target=_blank><img src="pictures/add_google_gadget.gif" border="0" /></a>
</td></tr>
</table>
</center>
