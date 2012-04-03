<?php session_start(); ?>
<html>
<head>
<title>deltasql - Topten</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
if (!file_exists($configurationfile)) die ("<h2><a href=\"install.php\">$installmessage</a></h2>"); else include("conf/config.inc.php");
include("utils/utils.inc.php");
include_once('utils/openflashchart/open_flash_chart_object.php');
echo "<br>";
echo "<h1>Top Ten</h1>";
echo "<hr>";
open_flash_chart_object( 500, 250, $dns_name . '/graphdata-submitters.php');
echo "<br><a href=\"topten_submitters.php\">Details...";
echo "</a><hr>";
open_flash_chart_object( 500, 250, $dns_name . '/graphdata-synchronizers.php');
echo "<br><a href=\"topten_synchronizers.php\">Details...";
?>
<hr>
<?php
if (isset($_SESSION['displayhelplinks'])) $displayhelp=$_SESSION['displayhelplinks']; else $displayhelp=$default_displayhelplinks;
if ($displayhelp==1)
  echo '<a href="faq.php#production"><img src="icons/help.png"> Is deltasql used in productive environments?</a></a><br>';
?>
<a href="index.php"><img src="icons/home.png"> Back to main menu</a>
</body>
</html>