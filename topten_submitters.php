<?php session_start(); ?>
<html>
<head>
<title>deltasql - Top Ten Submitters</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
if (!file_exists($configurationfile)) die ("<h2><a href=\"install.php\">$installmessage</a></h2>"); else include("conf/config.inc.php");
include("utils/utils.inc.php");
include_once('utils/openflashchart/open_flash_chart_object.php');

echo "<hr>";
open_flash_chart_object( 500, 250, $dns_name . '/graphdata/submitters.php');
echo "<hr>";

 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 $query="SELECT u.username, u.first, u.last, count(*) FROM tbuser u, tbscript s WHERE s.user_id=u.id GROUP BY u.id ORDER BY count(*) DESC";
 $result=mysql_query($query);
 
 if ($result=="") {
    mysql_close();
    die("<b>deltasql was not used until now</b>");
 } else {
  $num=mysql_numrows($result); 
 }

echo "<table border=1><tr>
<th>rank</th>
<th>who</th>
<th>first name</th>
<th>last name</th>
<th>count</th>
</tr>";
 
 $i=0;
 while ($i<$num) { 
   

   $username=mysql_result($result,$i,"username");
   $firstname=mysql_result($result,$i,"first");
   $lastname=mysql_result($result,$i,"last");
   
   $count=mysql_result($result,$i,"count(*)");          
   
   $rank = $i+1;
   
   echo "
    <tr>
    <td>$rank</td>
    <td>$username</td>
    <td>$firstname</td>
    <td>$lastname</td>
    <td>$count</td>
    </tr>";
  
   $i++;
 }
 echo "</table>";
 mysql_close();
 
 ?>
<?php include("bottom.inc.php"); ?>
</body>
</html>