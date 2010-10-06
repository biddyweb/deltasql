<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete project</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<3) die("<b>Not enough rights to delete a project.</b>");

$projectid = $_GET['id'];
if ($projectid=="") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

// deleting branches and scriptbranches
$query3="SELECT * from tbbranch where project_id=$projectid"; 
$result3=mysql_query($query3);
if ($result3!="") $num=mysql_numrows($result3); else $num=0;
$i=0;
while ($i<$num) {
 $branchid=mysql_result($result3,$i,"id");          
 $query4="DELETE FROM tbscriptbranch where branch_id=$branchid"; 
 $result4=mysql_query($query4);

 $query5="DELETE FROM tbbranch where id=$branchid"; 
 $result5=mysql_query($query5);
 $i++;
}

$query2="DELETE FROM tbmoduleproject where project_id=$projectid;";
mysql_query($query2);

$query="DELETE FROM tbproject where id=$projectid;";
mysql_query($query);

mysql_close();
js_redirect("list_projects.php");
?>

</body>
</html>