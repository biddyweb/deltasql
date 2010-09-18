<?php session_start();
$rights = $_SESSION["rights"];
if ($rights<3) die("<b>Not enough rights to get PHP version information.</b>");

phpinfo();
?>