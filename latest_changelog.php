<html>
<title>deltasql - Latest ChangeLog</title>
<body>
<?php
include("utils/constants.inc.php");
include("conf/config.inc.php");

// Stats for Google Analytics
 if ($dns_name=="http://www.deltasql.org/deltasql") {
 echo '
 <script type="text/javascript">
 var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
 document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
 </script>
 <script type="text/javascript">
 try{
  var pageTracker = _gat._getTracker("UA-22222509-1");
  pageTracker._trackPageview();
 } catch(err) {}
 </script>
 ';
 }

$version=$_GET['version'];
echo "<h2>Latest ChangeLog for $deltasql_version</h2>";
if ($version==$deltasql_version) {
  echo "<i>$deltasql_version is currently the latest available release from www.deltasql.org.</i>";
} else {
  echo "<i>Your deltasql server version is $version. A newer version $deltasql_version is available from www.deltasql.org. Read below for the latest changes...</i>";
}
echo "<hr>";

?>

<pre>
<?php include("docs/ChangeLog.txt"); ?>
</pre>
</body>
</html>