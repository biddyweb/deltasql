<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Show differences between revisions</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<br>

<?php
require_once 'Text/Diff.php';
require_once 'Text/Diff/Renderer.php';
require_once 'Text/Diff/Renderer/unified.php';

include("head.inc.php");
include("utils/diffutils.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");
include("utils/timing.inc.php");
$startwatch = start_watch();

if (isset($_SESSION['displayhelplinks'])) $displayhelp=$_SESSION['displayhelplinks']; else $displayhelp=$default_displayhelplinks;
if ($displayhelp==1)
   echo "<a href=\"faq.php#undefinedindex\"><img src=\"icons/help.png\"> Undefined index errors everywhere</a><br>";  

$scriptid = $_POST['scriptid'];
$version  = $_POST['version'];
$fromdiff = $_POST['fromdiff'];
$todiff   = $_POST['todiff'];
$differences = 0;
if ($scriptid=="") exit;
if ($fromdiff=="") die("<b>No source revision specified</b>");
if ($todiff=="") die("<b>No target revision specified</b>");

echo "<h2>Differences for version $version between revisions</h2>";
if ($fromdiff==$todiff) die("<b>There is no difference, both scripts are the same!</b>");

include("conf/config.inc.php");

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

if ($todiff!="latest") {
   $queryto="SELECT * from tbscriptchangelog where id=$todiff";
   $querytargetbranch="SELECT * from tbscriptbranchchangelog where script_id=$todiff";
} else {
   $queryto="SELECT * from tbscript where id=$scriptid";
   $querytargetbranch="SELECT * from tbscriptbranch where script_id=$scriptid";
}

// 1.  differences in branches assigned to the script
$branchesdifferences=0;
$branchesstring="";
// 1.1 branches which are in source but not in target
$querysourcebranch="SELECT * from tbscriptbranchchangelog where script_id=$fromdiff;";
$resultsb=mysql_query($querysourcebranch);
if ($resultsb=="") $numsb=0; else $numsb=mysql_numrows($resultsb);
$i=0;
while ($i<$numsb) {
  $branchid=mysql_result($resultsb,$i,"branch_id");
  // check if the branch is in target
  $checktarget="$querytargetbranch AND branch_id=$branchid;";
  $resulttarget=mysql_query($checktarget);  
  if ($resulttarget=="") $checknum=0; else $checknum=mysql_numrows($resulttarget);
  if ($checknum==0) {
	   $branchesdifferences++;
	   $queryname="SELECT * FROM tbbranch where id=$branchid";
	   $resultname=mysql_query($queryname);
	   $branchname=mysql_result($resultname,0,"name");
	   $branchesstring = "$branchesstring\n-$branchname";
  }
  $i++;
}

// 1.2 branches which are in target but not in source
$resultsb=mysql_query($querytargetbranch);
if ($resultsb=="") $numsb=0; else $numsb=mysql_numrows($resultsb);
$i=0;
while ($i<$numsb) {
  $branchid=mysql_result($resultsb,$i,"branch_id");
  // check if the branch is in source
  $checksource="SELECT * from tbscriptbranchchangelog where script_id=$fromdiff AND branch_id=$branchid;";
  $resultsource=mysql_query($checksource);  
  if ($resultsource=="") $checknum=0; else $checknum=mysql_numrows($resultsource);
  if ($checknum==0) {
	   $branchesdifferences++;
	   $queryname="SELECT * FROM tbbranch where id=$branchid";
	   $resultname=mysql_query($queryname);
	   $branchname=mysql_result($resultname,0,"name");
	   $branchesstring = "$branchesstring\n+$branchname";
  }
  $i++;
}

if ($branchesdifferences>0) {
  echo "<h3>Branches:</h3>";
  color_diff("$branchesstring\n");
  echo "<hr>";
}


// 2. differences in script itself
$queryfrom="SELECT * from tbscriptchangelog where id=$fromdiff";
$resultfrom=mysql_query($queryfrom);
$scriptfrom  =mysql_result($resultfrom,0,"code");
$commentsfrom=mysql_result($resultfrom,0,"comments");
$moduleidfrom=mysql_result($resultfrom, 0, "module_id");
$titlefrom=mysql_result($resultfrom, 0, "title");
$versionfrom=mysql_result($resultfrom, 0, "versionnr");

$resultto=mysql_query($queryto);
$scriptto  =mysql_result($resultto,0,"code");
$commentsto=mysql_result($resultto,0,"comments");
$moduleidto=mysql_result($resultto, 0, "module_id");
$titleto=mysql_result($resultto, 0, "title");
$versionto=mysql_result($resultto, 0, "versionnr");


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

if ($versionfrom!=$versionto) {
  echo "<h3>Version number:</h3>";
  color_diff("-$versionfrom\n+$versionto");
  echo "<hr>";
  $differences++;
}

if ($titlefrom!=$titleto) {
  echo "<h3>Title:</h3>";
  color_diff("-$titlefrom\n+$titleto");
  echo "<hr>";
  $differences++;
}

if ($moduleidfrom!=$moduleidto) {
  $querymod ="SELECT * from tbmodule WHERE id=$moduleidfrom";
  $resultmod=mysql_query($querymod);
  $modulefrom=mysql_result($resultmod,0,"name");
  
  $querymod ="SELECT * from tbmodule WHERE id=$moduleidto";
  $resultmod =mysql_query($querymod);
  $moduleto=mysql_result($resultmod,0,"name");
  
  echo "<h3>Modules:</h3>";
  color_diff("-$modulefrom\n+$moduleto");
  $differences++;
}


$lines1 = file($scriptfromfilename);
$lines2 = file($scripttofilename);
$diff = new Text_Diff('auto', array($lines1, $lines2));
$renderer = new Text_Diff_Renderer_unified();
$difftext = $renderer->render($diff); 
if ($difftext!="") {
   echo "<h3>Script:</h3>";
   color_diff($difftext);
   echo "<hr>";
   $differences++;
}
   
$lines1 = file($commentsfromfilename);
$lines2 = file($commentstofilename);
$diff = new Text_Diff('auto', array($lines1, $lines2));
$difftext = $renderer->render($diff); 

if ($difftext!="") {
   echo "<h3>Comments:</h3>";
   color_diff($difftext);
   echo "<hr>";
   $differences++;
}

if (($differences==0) && ($branchesdifferences==0)) echo "<br><b>No differences found.</b><br>";
   
unlink($scriptfromfilename);
unlink($scripttofilename);
unlink($commentsfromfilename);
unlink($commentstofilename);

mysql_close();
?>
<a href="list_scripts.php">Back to List Scripts</a> | <a href="index.php"><img src="icons/home.png"> Back to main page</a><br>
<?php echo "<h6>"; stop_watch($startwatch); echo "</h6>"; ?>
</body>
</html>