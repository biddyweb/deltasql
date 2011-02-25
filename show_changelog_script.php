<?php session_start(); ?>
<html>
<head>
<title>deltasql - Show Database Script (History)</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include_once('utils/geshi/geshi.php');
include("head.inc.php");
include("utils/utils.inc.php");
?>
<?php
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");
$histid = $_GET['histid'];
$clid = $_GET['clid'];
$version  = $_GET['version'];

$query="SELECT * from tbscriptchangelog where id=$clid"; 
$result=mysql_query($query);   

$id=mysql_result($result,0,"id");
$title=mysql_result($result,0,"title");           
$comments=mysql_result($result,0,"comments");
$create_dt=mysql_result($result,0,"create_dt");
$versionnr=mysql_result($result,0,"versionnr");
$moduleid=mysql_result($result,0,"module_id");
$script=mysql_result($result,0,"code");

echo "<h2>$title (History)</h2>";
// retrieve module id name
$query2="SELECT * from tbmodule where id=$moduleid"; 
$result2=mysql_query($query2);   
$modulename=mysql_result($result2, 0,  "name");
echo "Module: <b>$modulename</b> ";
echo "Version: <b>$versionnr</b> ";
echo "Create Datum: <b>$create_dt</b> ";

echo "Applied to: <b>Unavailable in History</b>";
echo "<br>";

echo "<hr><br>";

if ($comments!="") {
    echo "/*\n";
    echo "<pre>$comments</pre>";
    echo "\n*/";
    echo "<br><br>";
}

geshi_highlight($script, 'sql');

echo "<hr>";
echo "
</table>
</body>
</html>
";
mysql_close();
?>
