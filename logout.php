<?php 
session_start();
session_destroy(); 
?>
<html>
<head>
<title>deltasql - Logout</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
</body>
<?php
 include("utils/utils.inc.php");
 js_redirect("index.php");
?>
</html>