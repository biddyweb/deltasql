<?php session_start(); ?>
<html>
<head>
<title>deltasql - Reset User Password</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>

<?php
  include("head.inc.php");
  include("conf/config.inc.php");
  include("utils/utils.inc.php");
  show_user_level();
  $myrights = $_SESSION["rights"];
  if ($myrights<3) die("<b>Not enough rights to reset password!</b>"); 

  $id=$_GET['id'];
  $name=$_GET['name'];
  $c = uniqid (rand (),true);
  $sessionid = md5($c);
  $newpwd=substr($sessionid,0,6);
  
  mysql_connect($dbserver, $username, $password);
  @mysql_select_db($database) or die("Unable to select database");
  $hash_newpwd=salt_and_hash($newpwd, retrieve_salt());
  
  $query2="UPDATE tbuser SET password='****',passwhash='$hash_newpwd',encrypted=1 WHERE id=$id"; 
  $result2=mysql_query($query2); 
  mysql_close();
 
  echo "<p>Password for user <b>$name</b> reset to <b>$newpwd</b></p>";
  echo "<a href=\"list_users.php\">Back to List Users</a>";
?>

</body>
</html>
