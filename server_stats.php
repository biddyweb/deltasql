<?php session_start(); ?>
<html>
<head>
<title>deltasql - Server Statistics</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
if (!file_exists($configurationfile)) echo ("<h2><a href=\"install.php\">$installmessage</a></h2>"); else include("conf/config.inc.php");
include("utils/utils.inc.php");
include_once('utils/openflashchart/open_flash_chart_object.php');
echo "<br>";
echo "<h1>deltasql Server Statistics</h1>";
echo "<hr>";
open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] . ':'.$_SERVER['SERVER_PORT'] . '/deltasql/graphdata-scriptspermonth.php');
echo "<hr>";
open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] . ':'.$_SERVER['SERVER_PORT'] . '/deltasql/graphdata-scriptspermodule.php');
echo "<hr>";
open_flash_chart_object( 500, 250, 'http://'. $_SERVER['SERVER_NAME'] . ':'.$_SERVER['SERVER_PORT'] . '/deltasql/graphdata-syncspermonth.php');
echo "<hr>";
?>
<?php
if (isset($_SESSION['displayhelplinks'])) $displayhelp=$_SESSION['displayhelplinks']; else $displayhelp=$default_displayhelplinks;
if ($displayhelp==1)
  echo '<a href="faq.php#continouus"><img src="icons/help.png"> Is it possible to perform continouus database integration?</a></a><br>';
?>
<a href="index.php"><img src="icons/home.png"> Back to main menu</a>
</body>
</html>