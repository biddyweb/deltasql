<?php session_start(); ?>
<html> 
<head>
<title>deltasql - History of deleted scripts</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

$rights = $_SESSION["rights"];
if ($rights<3) die ("Not enough rights to see deleted scripts");
echo "<h3>List of deleted scripts</h3>";

include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbscriptchangelog where script_id NOT IN (select id from tbscript) ORDER BY id DESC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

echo "
<table border=\"1\">
<tr>
<th>versionnr</th>
<th>script</th>
<th>comments</th>
<th>author</th>
<th>update user</th>
<th>create dt</th>
<th>actions</th>
</tr>";

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$versionnr=mysql_result($result,$i,"versionnr");
$update_user=mysql_result($result,$i,"update_user");          
$create_dt=mysql_result($result,$i,"create_dt");
$script=htmlentities(mysql_result($result,$i,"code"));
$comments=htmlentities(mysql_result($result,$i,"comments"));
$userid=mysql_result($result,$i,"user_id");

$query2="SELECT * from tbuser where id=$userid"; 
$result2=mysql_query($query2);  
$author=mysql_result($result2,0,"username");

if (strlen($script)>35) {
        $script = substr($script, 0, 35);
        $script = "$script...";
}

if (strlen($comments)>10) {
    $comments = substr($comments, 0, 10);
    $comments = "$comments...";
}

echo "
<tr>
<td>$versionnr</td>
<td>$script</td>
<td>$comments</td>
<td>$author</td>
<td>$update_user</td>
<td>$create_dt</td>
<td><a href=\"show_script.php?id=$id&history=1\">Show</a></td>
</tr>";
 $i++;
}
?>
</table>
<br>

<a href="index.php">Back to main menu</a>
</body>
</html>