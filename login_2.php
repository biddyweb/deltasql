<?php session_start(); ?>
<html>
<head>
<title>deltasql - Login Check</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");

$link=mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");
$name=mysql_real_escape_string($_POST['name'], $link);
$pwd=mysql_real_escape_string($_POST['pwd'], $link);
if ($name == "") { mysql_close(); exit;}

$hash_pwd=salt_and_hash($pwd, retrieve_salt());
$query="SELECT * from tbuser WHERE username='$name' AND password='$pwd' AND encrypted=0 LIMIT 1"; 
$result=mysql_query($query); 
$nums=mysql_numrows($result);

$unencryptedfound=0;
if ($nums==0) {
  $query="SELECT * from tbuser WHERE username='$name' AND passwhash='$hash_pwd' AND encrypted=1 LIMIT 1"; 
  $result=mysql_query($query); 
  $nums=mysql_numrows($result);
  
  if ($nums==0) {
     mysql_close();
     die("<b><font color=\"red\">The user does not exist or the password is wrong.</font></b>");
  }	 
} else {
  $unencryptedfound=1;
}

 $rights=mysql_result($result, 0, "rights");
 $userid=mysql_result($result, 0, "id");
 $first =mysql_result($result, 0, "first");
 if ($unencryptedfound==1) {
     $query2="UPDATE tbuser SET password='****',passwhash='$hash_pwd',encrypted=1 WHERE id=$userid"; 
     $result2=mysql_query($query2); 
 }

 $_SESSION['username'] = $name;
 $_SESSION['rights'] = $rights;
 $_SESSION['userid'] = $userid;
 $_SESSION['first'] = $first;
 $_SESSION['scriptsperpage']   = get_parameter_default('UI','SCRIPTS_PER_PAGE',$userid,$default_scriptsperpage);
 $_SESSION['displayhelplinks'] = get_parameter_default('UI','DISPLAY_HELP_LINKS',$userid,$default_displayhelplinks);
 if (!isset($default_copypaste)) $default_copypaste=1;
 $_SESSION['copypaste']        =  get_parameter_default('UI','COPY_PASTE',$userid,$default_copypaste);
 $_SESSION['colorrows']        = get_parameter_default('UI','COLOR_ROWS',$userid,$default_colorrows);
 
 mysql_close();
 js_redirect("index.php");

?>
</body>
</html>