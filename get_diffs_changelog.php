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

echo "<h2>Differences for version $version</h2>";

if ($fromdiff==$todiff) die("<b>There is no difference, both scripts are the same!</b>");

include("conf/config.inc.php");

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$queryfrom="SELECT * from tbscriptchangelog where id=$fromdiff";
$resultfrom=mysql_query($queryfrom);
$scriptfrom  =mysql_result($resultfrom,0,"code");
$commentsfrom=mysql_result($resultfrom,0,"comments");

if ($todiff!="latest") {
   $queryto="SELECT * from tbscriptchangelog where id=$todiff";
} else {
   $queryto="SELECT * from tbscript where id=$scriptid";
}
$resultto=mysql_query($queryto);
$scriptto  =mysql_result($resultto,0,"code");
$commentsto=mysql_result($resultto,0,"comments");

// generating sessionid
$c = uniqid (rand (),true);
$sessionid = md5($c);

$scriptfromfilename="output/diffs/script_from_$sessionid.txt";
$scripttofilename="output/diffs/script_to_$sessionid.txt";
$commentsfromfilename="output/diffs/comments_from_$sessionid.txt";
$commentstofilename="output/diffs/comments_to_$sessionid.txt";

$fh = fopen($scriptfromfilename, 'w');
fwrite($fh, "$scriptfrom");
fclose($fh);

$fh = fopen($scripttofilename, 'w');
fwrite($fh, "$scriptto");
fclose($fh);

$fh = fopen($commentsfromfilename, 'w');
fwrite($fh, "$commentsfrom");
fclose($fh);

$fh = fopen($commentstofilename, 'w');
fwrite($fh, "$commentsto");
fclose($fh);


$lines1 = file($scriptfromfilename);
$lines2 = file($scripttofilename);
$diff = new Text_Diff('auto', array($lines1, $lines2));

echo "<h3>Script differences:</h3>";
echo "<pre>";
$renderer = new Text_Diff_Renderer_unified();
echo $renderer->render($diff);
echo "</pre>";
echo "<hr>";

$lines1 = file($commentsfromfilename);
$lines2 = file($commentstofilename);
$diff = new Text_Diff('auto', array($lines1, $lines2));

echo "<h3>Comment differences:</h3>";
echo "<pre>";
$renderer = new Text_Diff_Renderer_unified();
echo $renderer->render($diff);
echo "</pre>";
echo "<hr>";

unlink($scriptfromfilename);
unlink($scripttofilename);
unlink($commentsfromfilename);
unlink($commentstofilename);

mysql_close();
?>
</body>
</html>