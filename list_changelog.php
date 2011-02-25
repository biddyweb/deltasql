<?php session_start(); ?>
<html> 
<head>
<title>deltasql - List Changelog</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

$scriptid = $_GET['id'];
$version  = $_GET['version'];
$author   = $_GET['author'];
$upuser   = $_GET['updateuser'];
$updt     = $_GET['updatedt'];
if ($scriptid=="") exit;

echo "<h3>Changelog for <a href=\"show_script.php?id=$scriptid\">script $version</a> originally made by $author</h3>";

include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbscriptchangelog where script_id=$scriptid ORDER BY id DESC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

echo "
<table border=\"1\">
<tr>
<th>description</th>
<th>update user</th>
<th>create dt</th>
<th>actions</th>
</tr>";
echo "
<tr>
<td>Latest revision</td>
<td>$upuser</td>
<td>$updt</td>
<td><a href=\"show_script.php?id=$scriptid\">Show</a><td>
</tr>
";

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$update_user=mysql_result($result,$i,"update_user");          
$create_dt=mysql_result($result,$i,"create_dt");

if ($update_user=="") { 
  $description = "Initial revision";
  $update_user=$author;
} else $description = "";
echo "
<tr>
<td>$description</td>
<td>$update_user</td>
<td>$create_dt</td>
<td><a href=\"show_changelogscript.php?id=$id\">Show</a></td>
</tr>";
 $i++;
}
?>
</table>
<br>

<a href="list_scripts.php">Back to List scripts</a>
</body>
</html>