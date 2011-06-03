<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>deltasql - Login Check</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
$name=$_POST['name'];
$pwd=$_POST['pwd'];

if ($name == "") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbuser WHERE username='$name' AND password='$pwd' AND encrypted=0 LIMIT 1"; 
$result=mysql_query($query); 
$nums=mysql_numrows($result);

if ($nums==0) {

  $hash_pwd=md5($pwd);
  $query="SELECT * from tbuser WHERE username='$name' AND passwhash='$hash_pwd' AND encrypted=1 LIMIT 1"; 
  $result=mysql_query($query); 
  $nums=mysql_numrows($result);
  
  if ($nums==0) {
     mysql_close();
     die("<b>The user does not exist or the password is wrong.</b>");
  }	 
}

 $rights=mysql_result($result, 0, "rights");
 $userid=mysql_result($result, 0, "id");
 mysql_close();

 $_SESSION['username'] = $name;
 $_SESSION['rights'] = $rights;
 $_SESSION['userid'] = $user_id;
 js_redirect("index.php");

?>
</body>
</html>