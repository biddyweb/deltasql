<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete database script</title>
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
if ($rights<1) die("<b>Not enough rights to delete a database script.</b>");

$scriptid = $_GET['id'];
$versionnr = $_GET['version'];
$script = $_GET['script'];
$shortened = $_GET['short'];
if ($scriptid=="") exit;

echo "<h2>Please confirm script deletion (version number: $versionnr):</h2>";

echo "<pre>$script</pre><br>";

if ($shortened==1) echo " <b>...</b><br><br>";

echo "<p>Are you sure that you want to delete this script? If not, please press the <b>Back</b> button on your browser</p>";

echo "<ul>";
echo "<li><b><a href=\"delete_script.php?id=$scriptid\">Yes, delete it</a></b></li>";
echo "</ul>";
?>


</body>
</html>