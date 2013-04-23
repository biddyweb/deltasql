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