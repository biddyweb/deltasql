<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete branch</title>
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
if ($id=="") exit;

echo "<h2>Please confirm branch deletion:</h2>";

echo "Branch <b>$name</b><br><br>";

echo "<b>All scripts containing this branch will loose the branch mention.</b><br>";

echo "<p>Are you sure that you want to delete this branch? If not, please press the <b>Back</b> button on your browser</p>";

echo "<ul>";
echo "<li><b><a href=\"delete_branch.php?id=$id\">Yes, delete it</a></b></li>";
echo "</ul>";
?>


</body>
</html>