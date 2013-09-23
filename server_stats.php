<?php session_start(); ?>
<html>
<head>
<title>deltasql - Server Statistics</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
include("utils/timing.inc.php");
$startwatch=start_watch();

if (!file_exists($configurationfile)) die ("<h2><a href=\"install.php\">$installmessage</a></h2>"); else include("conf/config.inc.php");
include("utils/utils.inc.php");
include_once('utils/openflashchart/open_flash_chart_object.php');
echo "<br>";
echo "<h2>deltasql Server Statistics</h2>";
echo "<hr>";
echo "<table>";
echo "<tr><td>";
open_flash_chart_object( 500, 250, $dns_name . '/graphdata/scriptspermonth.php');
echo "</td><td>";
open_flash_chart_object( 500, 250, $dns_name . '/graphdata/scriptspermodule.php');
echo "</td></tr>";

echo "<tr><td>";
open_flash_chart_object( 500, 250, $dns_name . '/graphdata/syncspermonth.php');
echo "</td><td>";
open_flash_chart_object( 500, 250, $dns_name . '/graphdata/scriptsperproject.php');
echo "</td></tr>";
echo "</table>";

?>
<?php
if (isset($_SESSION['displayhelplinks'])) $displayhelp=$_SESSION['displayhelplinks']; else $displayhelp=$default_displayhelplinks;
if ($displayhelp==1)
  echo '<a href="faq.php#continouus"><img src="icons/help.png"> Is it possible to perform continouus database integration?</a></a><br>';
?>
<?php include("bottom.inc.php"); ?>
<?php echo "<h6>"; stop_watch($startwatch); echo "</h6>"; ?>
</body>
</html>