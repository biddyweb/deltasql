<?php session_start(); ?>
<html>
<head>
<title>deltasql - Export Project Form</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");
include("conf/config.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

if(isset($_SESSION['rights'])) {
  $rights = $_SESSION["rights"];
} else {
  $rights=0; 
}
if ($rights<2) die('<b>Not enough rights to export a project</b>');
?>  
<h1>Export Project Form</h1>  
  
<p>
This form exports all scripts belonging to a project in XML or HTML format for reporting purposes, or to integrate information stored by deltasql into other tools.
</p>  
  

</body>
</html>