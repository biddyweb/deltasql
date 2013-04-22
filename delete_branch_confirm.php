<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete branch or tag</title>
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
if ($rights<3) die("<b>Not enough rights to delete a branch.</b>");

$id = $_GET['id'];
$name = $_GET['name'];
$tag=$_GET["tag"];
if ($id=="") exit;

// if it is a branch, check if there are no other branches originating from it
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");
$query="select count(*) from tbbranch where sourcebranch_id=$id";
$result=mysql_query($query);
$numbranches=mysql_result($result,0,"count(*)");
mysql_close();
if ($numbranches>0) die("<b>Not possible to delete branch '$name' as there are other branches originating from it</b>");


if ($tag==0) { 
  echo "<h2>Please Confirm Branch Deletion:</h2>";
  echo "Branch <b>$name</b><br><br>";
  echo "<b>All scripts containing this branch will loose the branch mention.</b><br>";
}
else {
  echo "<h2>Please Confirm Tag Deletion:</h2>";
  echo "Tag <b>$name</b><br><br>";
}  

echo "<p>Are you sure that you want to delete this branch or tag? If not, please press the <b>Back</b> button on your browser</p>";

echo "<ul>";
echo "<li><b><a href=\"delete_branch.php?id=$id\">Yes, delete it</a></b></li>";
echo "</ul>";
?>

<?php include("bottom.inc.php"); ?>
</body>
</html>