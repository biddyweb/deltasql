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
include("utils/constants.inc.php");
include("utils/sendmail.inc.php");
include("changelog.inc.php");

$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<1) die("<b>Not enough rights to delete a database script.</b>");

$scriptid = $_GET['id'];
if ($scriptid=="") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

// store a backup copy of the script
copy_script_to_changelog($scriptid);

//email notification
// 4. Email notification
if ($emails_enable) {
  // retrieve script version
  $query22="SELECT * FROM tbscript WHERE id=$scriptid;";
  mysql_query($query22);
  $result22=mysql_query($query22);
  $version=mysql_result($result22,0,"versionnr");
  $body=mysql_result($result22,0,"code");;
  $branches=list_branches($scriptid);
  
  $subject="$emails_subject_identifier $version DELETED by $user for$branches";
  notify_users_with_email($sendmail_command,$deltasql_path,$emails_sender, $subject, $body);
}


$query2="DELETE FROM tbscriptbranch where script_id=$scriptid;";
mysql_query($query2);

$query="DELETE FROM tbscript where id=$scriptid;";
mysql_query($query);

mysql_close();
js_redirect("list_scripts.php");
?>

</body>
</html>