<?php session_start(); ?>
<html>
<head>
<title>deltasql - Top Ten Synchronizers</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>

<?php
include("head.inc.php");
include("utils/constants.inc.php");
if (!file_exists($configurationfile)) die ("<h2><a href=\"install.php\">$installmessage</a></h2>"); else include("conf/config.inc.php");
include("utils/utils.inc.php");
include_once('utils/openflashchart/open_flash_chart_object.php');
echo "<br>";

echo "<hr>";
open_flash_chart_object( 500, 250, $dns_name . '/graphdata-synchronizers.php');
echo "<hr>";


echo "<h2>List Synchronization History</h2>";

 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 $query="SELECT * FROM tbsyncstats ORDER BY update_dt DESC";
 $result=mysql_query($query);
 
 if ($result=="") {
    mysql_close();
    die("<b>deltasql was not used until now</b>");
 } else {
  $num=mysql_numrows($result); 
 }
 
 $query2="SELECT count(*) FROM tbsyncstats ORDER BY update_dt DESC";
 $result2=mysql_query($query2);
 
 $numsync=mysql_result($result2,0,"count(*)");
 echo "<p>Number of synchronizations: <b>$numsync</b></p>";

echo "<table border=1><tr>
<th>who</th>
<th>project</th>
<th>when</th>
<th>type</th>
<th>from</th>
<th>to</th>
<th>from</th>
<th>to</th>
<th>db type</th>
</tr>";


 
 
 $i=0;
 while ($i<$num) { 
   

   $projectname=mysql_result($result,$i,"projectname");
   $update_dt=mysql_result($result,$i,"update_dt");          
   $update_user=mysql_result($result,$i,"update_user");
   $update_type=mysql_result($result,$i,"update_type");
   $versionnr=mysql_result($result,$i,"versionnr");
   $branchname=mysql_result($result,$i,"branchname");
   $update_fromversion=mysql_result($result,$i,"update_fromversion");
   $update_fromsource=mysql_result($result,$i,"update_fromsource");
   $dbtype=mysql_result($result,$i,"dbtype");
   
   echo "
    <tr>
    <td>$update_user</td>
    <td>$projectname</td>
    <td>$update_dt</td>
    <td>$update_type</td>
    <td>$update_fromsource</td>
    <td>$branchname</td>
    <td>$update_fromversion</td>
    <td>$versionnr</td>
    <td>$dbtype</td>
    </tr>";
  
   $i++;
 }
 echo "</table>";
 mysql_close();
 
 ?>
<br>
<hr>
<a href="topten.php">Top Ten</a> | <a href="index.php"><img src="icons/home.png"> Main menu</a>
</body>
</html>
</body>
</html>