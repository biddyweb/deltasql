<?php session_start(); ?>
<html>
<head>
<title>deltasql - Download Deltasql Clients</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php 
include("head.inc.php"); 
?>
<h2>Download deltasql Clients</h2>
<p>
Instead of manually synchronizing with the <a href="dbsync.php">form</a> in the synchronization section on the server, you might want
to try out one of the clients below that connect to this server and which integrate into your development environment.
</p>
<center>
<img src="pictures/ant-dbredactor.png" border="0"><br>
<i>Picture: </i>the two Ant targets of dbredactor running in Eclipse
</center>
<br>
<?php
include("download_clients_table.inc.php");
?>
<br>
<center>
<img src="pictures/deltaclient-1.png" border="0">
<p><i>Picture:</i> deltaclient running on Windows 7.</p><br>
</center>
<?php
include("bottom.inc.php"); 
?>
</body>
</head>