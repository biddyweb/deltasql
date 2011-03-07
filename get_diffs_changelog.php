<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Show differences between revisions</title>
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
if ($fromdiff=="") die("<b>No source revision specified</b>");
if ($todiff=="") die("<b>No target revision specified</b>");

echo "<b><font color=\"red\">Please note: differences in applied branches are not shown!</font><br>";
echo "<h2>Differences for version $version between revisions</h2>";
if ($fromdiff==$todiff) die("<b>There is no difference, both scripts are the same!</b>");

include("conf/config.inc.php");

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$queryfrom="SELECT * from tbscriptchangelog where id=$fromdiff";
$resultfrom=mysql_query($queryfrom);
$scriptfrom  =mysql_result($resultfrom,0,"code");
$commentsfrom=mysql_result($resultfrom,0,"comments");
$moduleidfrom=mysql_result($resultfrom, 0, "module_id");

if ($todiff!="latest") {
   $queryto="SELECT * from tbscriptchangelog where id=$todiff";
} else {
   $queryto="SELECT * from tbscript where id=$scriptid";
}
$resultto=mysql_query($queryto);
$scriptto  =mysql_result($resultto,0,"code");
$commentsto=mysql_result($resultto,0,"comments");
$moduleidto=mysql_result($resultto, 0, "module_id");

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

if ($moduleidfrom!=$moduleidto) {
  $querymod ="SELECT * from tbmodule WHERE id=$moduleidfrom";
  $resultmod=mysql_query($querymod);
  $modulefrom=mysql_result($resultmod,0,"name");
  
  $querymod ="SELECT * from tbmodule WHERE id=$moduleidto";
  $resultmod =mysql_query($querymod);
  $moduleto=mysql_result($resultmod,0,"name");
  
  
  echo "<h3>Modules differences:</h3>";
  echo "<pre>";
  echo "-$modulefrom\n";
  echo "+$moduleto";
  echo "</pre>";
  echo "<hr>";
}


$lines1 = file($scriptfromfilename);
$lines2 = file($scripttofilename);
$diff = new Text_Diff('auto', array($lines1, $lines2));
$renderer = new Text_Diff_Renderer_unified();
$difftext = $renderer->render($diff); 
if ($difftext!="") {
   echo "<h3>Script differences:</h3>";
   echo "<pre>";
   echo $difftext;
   echo "</pre>";
   echo "<hr>";
}
   
$lines1 = file($commentsfromfilename);
$lines2 = file($commentstofilename);
$diff = new Text_Diff('auto', array($lines1, $lines2));
$difftext = $renderer->render($diff); 

if ($difftext!="") {
   echo "<h3>Comment differences:</h3>";
   echo "<pre>";
   echo $difftext;
   echo "</pre>";
   echo "<hr>";
}
   
unlink($scriptfromfilename);
unlink($scripttofilename);
unlink($commentsfromfilename);
unlink($commentstofilename);

mysql_close();
?>
</body>
</html>