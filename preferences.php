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
include("utils/timing.inc.php");
$startwatch=start_watch();

if (!isset($default_copypaste)) $default_copypaste=1;

if (isset($_POST['frm_submit'])) {
  $frm_scriptsperpage=$_POST['frm_scriptsperpage'];
  if (($frm_scriptsperpage<1) || ($frm_scriptsperpage>500)) 
     die('<font color="red"><b>Scripts per page has to be between 1 and 500!</b></font>');
  
  $frm_displayhelplinks=$_POST['helpgroup'];
  $frm_colorrows=$_POST['colorgroup'];
  if (!isset($_POST['frm_sendemailto']))  $frm_sendemailto=""; else $frm_sendemailto=$_POST['frm_sendemailto'];
  $frm_copypaste=$_POST['copypaste'];
 
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
  set_parameter('UI','COPY_PASTE',"$frm_copypaste",$userid);
  set_parameter('EMAIL','SEND_EMAIL_TO',"$frm_sendemailto",$userid);
  
  $_SESSION['scriptsperpage'] = $frm_scriptsperpage;
  $_SESSION['displayhelplinks'] = $frm_displayhelplinks;
  $_SESSION['colorrows'] = $frm_colorrows; 
  $_SESSION['copypaste'] = $frm_copypaste; 
  
  mysql_close();  
  js_redirect("index.php");
}


mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

echo "<h2>Preferences for $name</h2>";



$scriptsperpage   =  get_parameter_default('UI','SCRIPTS_PER_PAGE',$userid,$default_scriptsperpage);
$displayhelplinks =  get_parameter_default('UI','DISPLAY_HELP_LINKS',$userid,$default_displayhelplinks);
$colorrows        =  get_parameter_default('UI','COLOR_ROWS',$userid,$default_colorrows);
$copypaste        =  get_parameter_default('UI','COPY_PASTE',$userid,$default_copypaste);
$sendemailto      =  get_parameter_default('EMAIL','SEND_EMAIL_TO',$userid,$default_copypaste);

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

if ($copypaste=="1") {
   $paste_yeschecked="checked"; $paste_nochecked="";
} else {
   $paste_yeschecked=""; $paste_nochecked="checked";
}
mysql_close();	
?>
<hr>
<form action="preferences.php" method="post">
<table>
<tr><td><h3>Password</h3></td><td></td></tr>
<tr><td></td><td><a href="change_password.php">Change Password <img src="icons/rights.png"></td></tr>

<tr><td><h3>General</h3></td><td></td></tr>
<tr><td>Display Help Links <img src="icons/help.png">:</td>
<td>
<input type="radio" name="helpgroup" value="1" <?php echo "$dhl_yeschecked"; ?>> Yes 
<input type="radio" name="helpgroup" value="0"  <?php echo "$dhl_nochecked"; ?>> No
<input type="hidden" name="frm_submit" value="1">
</td></tr>

<tr><td>Enable Copy-Paste Functionality <img src="icons/copy.png">:</td>
<td>
<input type="radio" name="copypaste" value="1" <?php echo "$paste_yeschecked"; ?>> Yes 
<input type="radio" name="copypaste" value="0"  <?php echo "$paste_nochecked"; ?>> No
</td></tr>

<?php
  if (isset($emails_enable) && ($emails_enable)) {
  echo "<tr><td><b>Send me an email at </b></td>";
  echo "<td><input type=\"text\" name=\"frm_sendemailto\" value=\"$sendemailto\" size=\"45\"> <b>when a new script is inserted in deltasql server.</b></td></tr>";
  }
?>
<tr><td><h3>'List Scripts' page</h3></td><td></td></tr>
<tr><td>Color new scripts:</td>
<td>
<input type="radio" name="colorgroup" value="1" <?php echo "$cns_yeschecked"; ?>> Yes 
<input type="radio" name="colorgroup" value="0"  <?php echo "$cns_nochecked"; ?>> No
</td></tr>
<tr><td>Number of scripts to be shown at once:</td>
<td><input type="text" name="frm_scriptsperpage" value="<?php echo "$scriptsperpage"; ?>" size="5"></td></tr>

<tr><td></td><td><input type="Submit" value="Save preferences"></td></tr>
</table>
</form>

<?php
if (isset($_SESSION['displayhelplinks'])) $displayhelp=$_SESSION['displayhelplinks']; else $displayhelp=$default_displayhelplinks;
if ($displayhelp==1)  
   echo '<a href="faq.php#email"><img src="icons/help.png"> How to configure email notification for new scripts</a><br>';
?>

<?php echo "<h6>"; stop_watch($startwatch); echo "</h6>"; ?>
<?php include("bottom.inc.php"); ?>
</body>
</html>