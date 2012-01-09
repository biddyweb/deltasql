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
echo "<hr><a href=\"change_password.php\">Change Password <img src=\"icons/rights.png\"></a><br><br>";

$scriptsperpage   =  get_parameter_default('UI','SCRIPTS_PER_PAGE',$userid,$default_scriptsperpage);
$displayhelplinks =  get_parameter_default('UI','DISPLAY_HELP_LINKS',$userid,$default_displayhelplinks);

if ($displayhelplinks) {
   $yeschecked="checked"; $nochecked="";
} else {
   $yeschecked=""; $nochecked="checked";
}
mysql_close();	
?>
<hr>
<form action="preferences.php" method="post">
<table>
<tr><td>Display Help Links (<img src="icons/help.png">):</td>
<td>
<input type="radio" name="helpgroup" value="1" <?php echo "$yeschecked"; ?>> Yes 
<input type="radio" name="helpgroup" value="0"  <?php echo "$nochecked"; ?>> No
<input type="hidden" name="frm_submit" value="1">
</td></tr>
<tr><td>Number of scripts in 'List scripts' page:</td>
<td><input type="text" name="frm_scriptsperpage" value="<?php echo "$scriptsperpage"; ?>" size="5"></td></tr>
<tr><td></td><td><input type="Submit" value="Save preferences"></td></tr>
</table>
</form>

<hr>
<a href="index.php"><img src="icons/home.png"> Back to main menu</a>    
<?php
if (isset($_POST['frm_submit'])) {
  $frm_scriptsperpage=$_POST['frm_scriptsperpage'];
  if (($frm_scriptsperpage<1) || ($frm_scriptsperpage>500)) 
     die('<font color="red"><b>Scripts per page has to be between 1 and 500!</b></font>');
  $frm_displayhelplinks=$_POST['helpgroup'];
  mysql_connect($dbserver, $username, $password);
  @mysql_select_db($database) or die("Unable to select database");	 
  set_parameter('UI','SCRIPTS_PER_PAGE',"$frm_scriptsperpage",$userid);
  set_parameter('UI','DISPLAY_HELP_LINKS',"$frm_displayhelplinks",$userid);
  
  $_SESSION['scriptsperpage'] = $frm_scriptsperpage;
  $_SESSION['displayhelplinks'] = $frm_displayhelplinks;
  mysql_close();  
  js_redirect("index.php");
}
?>
</body>
</html>