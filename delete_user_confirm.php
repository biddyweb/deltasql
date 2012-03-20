<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete User</title>
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
if ($rights<3) die("<b>Not enough rights to delete a user.</b>");

$id = $_GET['id'];
$name = $_GET['name'];
if ($id=="") exit;

echo "<h2>Please confirm user deletion:</h2>";

echo "User <b>$name</b><br><br>";

echo "<p>Existing scripts submitted by this user will be assigned to the user <b>admin</b>.</p>";
echo "<p>Are you sure that you want to delete this user? If not, please press the <b>Back</b> button on your browser</p>";

echo "<ul>";
echo "<li><b><a href=\"delete_user.php?id=$id\">Yes, delete it</a></b></li>";
echo "</ul>";
?>

<hr>
<a href="index.php"><img src="icons/home.png"> Back to main menu</a>
</body>
</html>