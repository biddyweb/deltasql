<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete module</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<3) die("<b>Not enough rights to delete a database module.</b>");

$id = $_GET['id'];
$name = $_GET['name'];
if ($id=="") exit;

echo "<h2>Please Confirm Module Deletion:</h2>";

echo "Module <b>$name</b><br><br><br>";

echo "<b>All scripts belonging to this module will also be deleted.</b><br>";
echo "<b>All projects containing this module will loose it.</b><br>";

echo "<p>Are you sure that you want to delete this module? If not, please press the <b>Back</b> button on your browser</p>";

echo "<ul>";
echo "<li><b><a href=\"delete_module.php?id=$id\">Yes, delete it</a></b></li>";
echo "</ul>";
?>

<?php include("bottom.inc.php"); ?>
</body>
</html>