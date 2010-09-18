<html>
<head>
<title>deltasql - Get Synchronization Table</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
include("head.inc.php");

$id=$_GET['id'];
$name=$_GET['name'];
echo "<h3>Get Synchronization Table for $name</h3>";
echo "Please choose the <b>Database Type</b> for your $name schema: <br><br>";

echo "
<form name=\"databasetype\" id=\"databasetype\" method=\"post\" action=\"synchronization_table.php\">
";

 printDatabaseComboBox($dbdefault);

 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");

 echo "Please select if the Database Schema will <b>follow HEAD or stay a branch</b>: <br><br>";
 echo "<select NAME=\"frmsourcebranch\">";
 //$headid=retrieve_head_id();
 $query="SELECT * FROM tbbranch where (project_id=$id) order by id ASC";
 $result=mysql_query($query);
 $num=mysql_numrows($result); 
 $i=0;
 echo "<option SELECTED VALUE=\"HEAD\">HEAD";

 while ($i<$num) { 
   $branchid=mysql_result($result,$i,"id");
   $branchname=mysql_result($result,$i,"name");
   echo "<option ";
   echo "VALUE=\"$branchname\">$branchname";
   $i++;
 }
 echo "</select><br><br>";
 mysql_close();
?>
<?php
echo "<input type=\"hidden\" name=\"frmprojectid\"  value=\"$id\">";
echo "<input type=\"hidden\" name=\"frmprojectname\"  value=\"$name\">";
/*
// disabled as it creates confusion
You also can give a name to your schema <i>(optional)</i><br>
<b>Schema Name: </b>  
<input type="text" name="frmschemaname" size="30"><br><br>
*/
?>

<input type="Submit">
</form>
</body>
</html>
