<?php session_start(); ?>
<html> 
<head>
<title>deltasql - History</title>
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

echo "<h3>History for <a href=\"show_script.php?id=$scriptid\">script $version</a>";

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
<th>script</th>
<th>comments</th>
</tr>";
echo "
<tr>
<td><b>Latest revision</b></td>
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
$script=htmlentities(mysql_result($result,$i,"code"));
$comments=htmlentities(mysql_result($result,$i,"comments"));

$scriptonlist = $script;
if (strlen($script)>35) {
        $scriptonlist = substr($script, 0, 35);
        $scriptonlist = "$scriptonlist<b>...</b>";
}

if (strlen($comments)>10) {
    $comments = substr($comments, 0, 10);
    $comments = "$comments<b>...</b>";
}

if ($update_user=="") { 
  $description = "<b>Initial revision</b>";
  $update_user=$author;
} else $description = "";
echo "
<tr>
<td>$description</td>
<td>$update_user</td>
<td>$create_dt</td>
<td><a href=\"show_script.php?id=$id&history=1\">Show</a></td>
<td>$scriptonlist</td>
<td>$comments</td>
</tr>";
 $i++;
}
?>
</table>
<br>

<a href="list_scripts.php">Back to List scripts</a>
</body>
</html>