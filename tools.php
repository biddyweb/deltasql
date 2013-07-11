<?php session_start(); ?>
<html>
<head>
<title>deltasql - Download Deltasql Tools</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php 
include("head.inc.php"); 
include("utils/constants.inc.php");
?>
<h2>deltasql Toolbox</h2>
<p>Here, we present tools which can be used in conjunction with deltasql.</p>

<center>
<table border="1">
<tr><th>tool</th><th>help</th><th>environment</th><th>description</th><th>version</th><th>actions</th></tr>

<tr>
<td><b>createinsertsfromcsv</b></td>
<td>
<?php
//<a href="manual.php#install-deltaclient-windows"><img src="icons/help.png"></a>
?>
</td>
<td>Windows (Freepascal)</td>
<td>
This tool takes a file in format CSV (comma separated values) and converts it into a list of SQL INSERT statements. When configuring complex environments with new rows via application GUI, you could select the new rows entered through your SQL client of 
 choice, then save the results of the SELECT statement as .csv. With this tool, you will convert the .csv file into INSERT statements that you can execute into other environments as well, with a simple click. 
 This will avoid the tedious manual configuration process for other environments, in particular if you store the generated INSERT statements as script into deltasql server.
</td>
<td><?php echo "$tool_createinsertsfromcsv"; ?>
</td><td><a href="tools/freepascal/createinsertsfromcsv.zip"><center>download...</center></a></td>
</tr>


</table>
</center>
<br>
<br>

<center>
<img src="pictures/createinsertsfromcsv.png" border="0">
<p><i>Picture:</i> createinsertsfromcsv: this simple tool creates a list of SQL insert statements taken from a CSV file.</p><br>
</center>
<?php
include("bottom.inc.php"); 
?>
</body>
</head>