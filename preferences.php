<?php session_start(); ?>
<html>
<head>
<title>User Preferences</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
$rights = $_SESSION["rights"];
$name   = $_SESSION["username"];
$userid = $_SESSION["userid"];

if ($rights<1) die("<b>Need to be logged in to change preferences.</b>");
include("head.inc.php");
include("utils/constants.inc.php");
include("utils/utils.inc.php");
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

echo "<h2>User preferences for $name</h2>";
echo "<a href=\"change_password.php\">Change Password <img src=\"icons/rights.png\"></a><br>";

$test  =  get_parameter_default('PARI','PARA',$userid,'no parameter');
$test2 =  get_parameter_default('GLOBAL','VERSION',"",'no parameter 2');
//echo "Test parameter is '$test'.<br>"; 
//echo "Second test parameter is '$test2'."; 


mysql_close();	
?>

<hr>
<a href="index.php"><img src="icons/home.png"> Back to main menu</a>
</body>
</html>