<?php session_start(); ?>
<html>
<head>
<title>deltasql - Login Check</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
$name=$_POST['name'];
$pwd=$_POST['pwd'];

if ($name == "") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

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
 mysql_close();

 $_SESSION['username'] = $name;
 $_SESSION['rights'] = $rights;
 $_SESSION['userid'] = $user_id;
 $_SESSION['first'] = $first;
 
 js_redirect("index.php");

?>
</body>
</html>