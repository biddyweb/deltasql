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
if ($scriptid=="") exit;

echo "<h3>History for <a href=\"show_script.php?id=$scriptid\">script $version</a>";

include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query2="SELECT * from tbscript where id=$scriptid";
$result2=mysql_query($query2);
$upuser=mysql_result($result2,0,"update_user");          
$updt=mysql_result($result2,0,"update_dt");
$script=htmlentities(mysql_result($result2,0,"code"));
$comments=htmlentities(mysql_result($result2,0,"comments"));

if (strlen($script)>35) {
        $script = substr($script, 0, 35);
        $script = "$script...";
}

if (strlen($comments)>10) {
    $comments = substr($comments, 0, 10);
    $comments = "$comments...";
}

$query="SELECT * from tbscriptchangelog where script_id=$scriptid ORDER BY id DESC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

echo "<form action=\"get_diffs_changelog.php\" method=\"post\">";
echo "
<table border=\"1\">
<tr>
<th></th>
<th></th>
<th>description</th>
<th>update user</th>
<th>create dt</th>
<th>actions</th>
<th>script</th>
<th>comments</th>
</tr>";
echo "
<tr>
<td></td><td><input type=\"radio\" name=\"todiff\" value=\"latest\" checked></td>
<td><b>Latest revision</b></td>
<td>$upuser</td>
<td>$updt</td>
<td><a href=\"show_script.php?id=$scriptid\">Show</a></td>
<td>$script</td>
<td>$comments</td>
</tr>
";

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$update_user=mysql_result($result,$i,"update_user");          
$create_dt=mysql_result($result,$i,"create_dt");
$script=htmlentities(mysql_result($result,$i,"code"));
$comments=htmlentities(mysql_result($result,$i,"comments"));

if (strlen($script)>35) {
        $script = substr($script, 0, 35);
        $script = "$script...";
}

if (strlen($comments)>10) {
    $comments = substr($comments, 0, 10);
    $comments = "$comments...";
}

if ($update_user=="") { 
  $description = "<b>Initial revision</b>";
  $update_user=$author;
  $diffcells = "<td><input type=\"radio\" name=\"fromdiff\" value=\"$id\" checked></td><td></td>";
} else {
  $description = "";
  $diffcells = "<td><input type=\"radio\" name=\"fromdiff\" value=\"$id\"></td><td><input type=\"radio\" name=\"todiff\" value=\"$id\"></td>";
}
echo "
<tr>
$diffcells
<td>$description</td>
<td>$update_user</td>
<td>$create_dt</td>
<td><a href=\"show_script.php?id=$id&history=1\">Show</a></td>
<td>$script</td>
<td>$comments</td>
</tr>";
 $i++;
}
?>
</table>
<input type="Submit" value="Get diffs between revisions">
</form>
<br>
<a href="list_scripts.php">Back to List scripts</a>
</body>
</html>