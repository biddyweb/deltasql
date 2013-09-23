<?php session_start(); ?>
<html>
<head>
<title>deltasql - Show Database Script</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<?php
 include_once('utils/geshi/geshi.php');
 include("head.inc.php");
 include("utils/utils.inc.php");
 include("conf/config.inc.php");
 include("utils/copypaste.inc.php");
 
 if (!isset($default_copypaste)) $default_copypaste=1;
 printCopyPasteJS($default_copypaste);

 echo "<body>";


if (isset($_GET['edit'])) $edit=$_GET['edit']; else $edit=0;
if (isset($_SESSION["userid"])) {
  $rights = $_SESSION["rights"];
  $sessionuserid = $_SESSION["userid"];
} else {
  $rights = 0; $sessionuserid="";
} 

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");
$scriptid = $_GET['id'];
if (isset($_GET['history'])) $history  = $_GET['history']; else $history=0;
if ($history==1) $changelog="changelog"; else $changelog="";

$query="SELECT * from tbscript$changelog where id=$scriptid"; 
$result=mysql_query($query);   

$id=mysql_result($result,0,"id");
$title=htmlentities(mysql_result($result,0,"title"));           
$comments=mysql_result($result,0,"comments");
$create_dt=mysql_result($result,0,"create_dt");
$versionnr=mysql_result($result,0,"versionnr");
$moduleid=mysql_result($result,0,"module_id");
$script=mysql_result($result,0,"code");
$userid=mysql_result($result,0,"user_id");
$update_user=mysql_result($result,0,"update_user");

$query2="SELECT * from tbuser where id=$userid"; 
$result2=mysql_query($query2);  
$author=mysql_result($result2,0,"username");

if ($history==1) 
 echo "<h2>History for Script $versionnr ($title)</h2>";
else
 echo "<h2>$title</h2>";
// retrieve module id name
$query2="SELECT * from tbmodule where id=$moduleid"; 
$result2=mysql_query($query2);   
$modulename=mysql_result($result2, 0,  "name");
echo "Module: <b>$modulename</b> ";
echo "Version: <b>$versionnr</b> ";
echo "Create Datum: <b>$create_dt</b> ";
echo "Author: <b>$author</b> ";
if ($update_user!="") echo "Updater: <b>$update_user</b> ";

// retrieve to which branches the script is applied
// retrieve to which branches and HEAD the script was applied
$query3="SELECT * from tbscriptbranch$changelog sb, tbbranch b where (sb.script_id=$id) and (sb.branch_id=b.id) order by b.id asc"; 
$result3=mysql_query($query3);   
$num3=mysql_numrows($result3);
$j=0;
echo "Applied to: ";
while ($j <$num3) {  
    $branchname=mysql_result($result3,$j,"name");   
    echo " <b>$branchname</b> ";
    $j++;
}
echo "<br>";

echo "Actions: ";
// if rights allow it, we show the script as editable
if ($edit==1) {
  $actions=0;
  if ($rights>=1) {
        echo "<a href=\"edit_script.php?id=$id\"><img alt=\"Edit\" src=\"icons/edit.png\">Edit</a> | ";
        $actions=1;  		
  }
  if ($update_user!="") {
        $actions=1;
	    $author_encoded = urlencode ( $author );
	    echo "<a href=\"list_changelog.php?id=$id&version=$versionnr&author=$author_encoded\"><img alt=\"History\" src=\"icons/history.png\">History</a> | ";
  } 
} 

printCopyPasteLink("Copy to clipboard", 0, $default_copypaste); 
echo "<hr><br>";

if ($comments!="") {
    echo "/*\n";
    echo "<pre>$comments</pre>";
    echo "\n*/";
    echo "<br><br>";
}

geshi_highlight($script, 'sql');

mysql_close();
include("bottom-with-navbar.inc.php");
?>

<?php
// repeating the script for copy&paste purposes
$intro = "";
if ($comments!="") {
    $intro = "/*\n$comments\n*/\n";
}
printCopyPasteBlock("$intro$script", $default_copypaste);
?>

</body>
</html>
