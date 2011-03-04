<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Show differences</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
require_once 'Text/Diff.php';
require_once 'Text/Diff/Renderer.php';
require_once 'Text/Diff/Renderer/unified.php';

include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

$scriptid = $_POST['scriptid'];
$version  = $_POST['version'];
$fromdiff = $_POST['fromdiff'];
$todiff   = $_POST['todiff'];
if ($scriptid=="") exit;
if ($fromdiff==$todiff) die("<b>There is no difference, both scripts are the same!</b>");

include("conf/config.inc.php");

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$queryfrom="SELECT * from tbscriptchangelog where id=$fromdiff";
$resultfrom=mysql_query($queryfrom);
$scriptfrom  =mysql_result($resultfrom,0,"code");
$commentsfrom=mysql_result($resultfrom,0,"comments");
$titlefrom=mysql_result($resultfrom,0,"title");

if ($todiff!="latest") {
   $queryto="SELECT * from tbscriptchangelog where id=$todiff";
} else {
   $queryto="SELECT * from tbscript where id=$scriptid";
}
$resultto=mysql_query($queryto);
$scriptto  =mysql_result($resultto,0,"code");
$commentsto=mysql_result($resultto,0,"comments");
$titleto=mysql_result($resultto,0,"title");

// generating sessionid
$c = uniqid (rand (),true);
$sessionid = md5($c);

$scriptfromfilename="output/diffs/script_from_$sessionid.txt";
$scripttofilename="output/diffs/script_to_$sessionid.txt";

$fh = fopen($scriptfromfilename, 'w');
fwrite($fh, "$scriptfrom");
fclose($fh);

$fh = fopen($scripttofilename, 'w');
fwrite($fh, "$scriptto");
fclose($fh);

$lines1 = file($scriptfromfilename);
$lines2 = file($scripttofilename);
$diff = new Text_Diff('auto', array($lines1, $lines2));

echo "<pre>";
$renderer = new Text_Diff_Renderer_unified();
echo $renderer->render($diff);
echo "</pre>";

unlink($scriptfromfilename);
unlink($scripttofilename);

mysql_close();
?>
</body>
</html>