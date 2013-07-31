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
<p>Here, we present tools which can be used in conjunction with deltasql. The tools are intended to help you in SQL script creation, the script might finish in deltasql server thereafter. If you have own tools that you would like to publish here, we would be glad to hear from you!</p>

<center>
<img src="pictures/createinsertsfromcsv.png" border="0">
<p><i>Picture:</i> createinsertsfromcsv: this simple tool creates a list of SQL insert statements taken from a CSV file.</p><br>
</center>

<center>
<table border="1">
<tr><th>tool</th><th>environment</th><th>description</th><th>version</th><th>author</th><th>actions</th></tr>

<tr>
<td><b>createinsertsfromcsv</b></td>
<td>Windows (Freepascal)</td>
<td>
This tool takes a file in format CSV (comma separated values) and converts it into a list of SQL INSERT statements. When configuring complex environments with new rows via application GUI, you could select the new rows entered through your SQL client of 
 choice, then save the results of the SELECT statement as .csv. With this tool, you will convert the .csv file into INSERT statements that you can execute into other environments as well, with a simple click. 
 This will avoid the tedious manual configuration process for other environments, in particular if you store the generated INSERT statements as script into deltasql server.
</td>
<td><?php echo "$tool_createinsertsfromcsv"; ?>
</td>
<td>deltasql team</td>
<td><a href="tools/freepascal/createinsertsfromcsv.zip"><center>download...</center></a></td>
</tr>

<tr>
<td><b>fromcsvdiffcreatesql</b></td>
<td>Windows (Freepascal)</td>
<td>
This tool takes two files in format CSV (comma separated values) and converts them into a list of SQL INSERT, UPDATE and DELETE statements. The SQL statements can be used to convert the first CSV into the second. When configuring complex environments via application GUI, you could export a table from the database in CSV before doing configuration changes, then do all configuration changes and then reexport the table as CSV with another filename after the configuration changes. This tool will then create a synchronization script you can apply to other database instances, without the burden of redoing everything manually. 
</td>
<td><?php echo "$tool_fromcsvdiffcreatesql"; ?>
</td>
<td>deltasql team</td>
<td><a href="tools/freepascal/fromcsvdiffcreatesql.zip"><center>download...</center></a></td>
</tr>


</table>
</center>
<br>
<br>

<center>
<img src="pictures/fromcsvdiffcreatesql.png" border="0">
<p><i>Picture:</i> fromcsvdiffcreatesql: this tool creates a SQL synchronization script based on two CSV files.</p><br>
</center>
<?php
include("bottom.inc.php"); 
?>
</body>
</head>