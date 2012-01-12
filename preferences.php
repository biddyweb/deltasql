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

if (isset($_POST['frm_submit'])) {
  $frm_scriptsperpage=$_POST['frm_scriptsperpage'];
  if (($frm_scriptsperpage<1) || ($frm_scriptsperpage>500)) 
     die('<font color="red"><b>Scripts per page has to be between 1 and 500!</b></font>');
  
  $frm_displayhelplinks=$_POST['helpgroup'];
  $frm_colorrows=$_POST['colorgroup'];
  $frm_sendemailto=$_POST['frm_sendemailto'];
 
  if (isset($emails_enable) && ($emails_enable) && ($frm_sendemailto!="")) {
     $pos = strpos($frm_sendemailto,"@");
     if (!$pos) {
  	     die("<font color=\"red\"><b>$frm_sendemailto is not a valid email address!</b></font>");
	 } 
  }

  mysql_connect($dbserver, $username, $password);
  @mysql_select_db($database) or die("Unable to select database");	 
  
  set_parameter('UI','SCRIPTS_PER_PAGE',"$frm_scriptsperpage",$userid);
  set_parameter('UI','DISPLAY_HELP_LINKS',"$frm_displayhelplinks",$userid);
  set_parameter('UI','COLOR_ROWS',"$frm_colorrows",$userid);
  set_parameter('EMAIL','SEND_EMAIL_TO',"$frm_sendemailto",$userid);
  
  $_SESSION['scriptsperpage'] = $frm_scriptsperpage;
  $_SESSION['displayhelplinks'] = $frm_displayhelplinks;
  $_SESSION['colorrows'] = $frm_colorrows; 
  mysql_close();  
  js_redirect("index.php");
}

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

echo "<h2>User preferences for $name</h2>";

$scriptsperpage   =  get_parameter_default('UI','SCRIPTS_PER_PAGE',$userid,$default_scriptsperpage);
$displayhelplinks =  get_parameter_default('UI','DISPLAY_HELP_LINKS',$userid,$default_displayhelplinks);
$colorrows        =  get_parameter_default('UI','COLOR_ROWS',$userid,$default_colorrows);
$sendemailto      =  get_parameter_default('EMAIL','SEND_EMAIL_TO',$userid,"");

if ($displayhelplinks=="1") {
   $dhl_yeschecked="checked"; $dhl_nochecked="";
} else {
   $dhl_yeschecked=""; $dhl_nochecked="checked";
}

if ($colorrows=="1") {
   $cns_yeschecked="checked"; $cns_nochecked="";
} else {
   $cns_yeschecked=""; $cns_nochecked="checked";
}
mysql_close();	
?>
<hr>
<form action="preferences.php" method="post">
<table>
<tr><td><h4>Password</h4></td><td></td></tr>
<tr><td></td><td><b><a href="change_password.php">Change Password <img src="icons/rights.png"></td></tr>

<tr><td><h4>General</h4></td><td></td></tr>
<tr><td><b>Display Help Links (<img src="icons/help.png">):</b></td>
<td>
<input type="radio" name="helpgroup" value="1" <?php echo "$dhl_yeschecked"; ?>> Yes 
<input type="radio" name="helpgroup" value="0"  <?php echo "$dhl_nochecked"; ?>> No
<input type="hidden" name="frm_submit" value="1">
</td></tr>

<?php
  if (isset($emails_enable) && ($emails_enable)) {
  echo "<tr><td><b>Send me an email at </b></td>";
  echo "<td><input type=\"text\" name=\"frm_sendemailto\" value=\"$sendemailto\" size=\"45\"> <b>when a new script is inserted in deltasql server.</b></td></tr>";
  }
?>
<tr><td><h4>'List Scripts' page</h4></td><td></td></tr>
<tr><td><b>Color new scripts:</b></td>
<td>
<input type="radio" name="colorgroup" value="1" <?php echo "$cns_yeschecked"; ?>> Yes 
<input type="radio" name="colorgroup" value="0"  <?php echo "$cns_nochecked"; ?>> No
</td></tr>
<tr><td><b>Number of scripts to be shown at once:</b></td>
<td><input type="text" name="frm_scriptsperpage" value="<?php echo "$scriptsperpage"; ?>" size="5"></td></tr>

<tr><td></td><td><input type="Submit" value="Save preferences"></td></tr>
</table>
</form>

<hr>
<a href="index.php"><img src="icons/home.png"> Back to main menu</a>    
</body>
</html>