<?php session_start(); ?>
<html>
<head>
<title>deltasql - Reset User Password</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>

<?php
  include("head.inc.php");
  include("utils/utils.inc.php");
  show_user_level();
  $myrights = $_SESSION["rights"];
  if ($myrights<3) die("<b>Not enough rights to reset password!</b>"); 

  $id=$_GET['id'];
  $name=$_GET['name'];
  $encoded_name=(urlencode($name));
  echo "<h2>Please confirm Password Reset</h2>";
  echo "<p>Are you sure that you want to reset the password for user <b>$name</b>? If not, please press the <b>Back</b> button on your browser<p>";
  echo "<p>If you really want to reset the password for user <b>$name</b> click on Yes below.</p>";
  echo "<ul><li><a href=\"reset_user_password_2.php?id=$id&name=$encoded_name\">Yes, reset it!</a></li></ul>";
  include("bottom.inc.php");
?>

</body>
</html>
