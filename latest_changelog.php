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

if (isset($_GET['version'])) $version=$_GET['version']; else $version="unknown";
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

<?php
if (($dns_name=="http://www.deltasql.org/deltasql") && ($version!="unknown")) {
  $ip        = $_SERVER['REMOTE_ADDR'];
  $port      = $_SERVER['REMOTE_PORT'];
  $referrer  = $_SERVER['HTTP_REFERER'];
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  $scripts = $_GET['scripts'];
  if ($scripts=="") $scripts=-1;
  
  if (($referrer!="http://www.deltasql.org/deltasql/") &&
      ($referrer!="http://www.deltasql.org/deltasql/index.php") &&
	  ($referrer!=""))   {
     mysql_connect($dbserver, $username, $password);
     @mysql_select_db($database) or die("Unable to select database");
     $query="INSERT INTO tbqos (id, deltasql_version, nbscripts, ip, port, referrer, useragent, create_dt) VALUES('', '$version', $scripts, '$ip', '$port', '$referrer', '$useragent', NOW());";
     mysql_query($query);
     mysql_close();
  }	 
}

/*
CREATE TABLE IF NOT EXISTS `tbqos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deltasql_version` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `nbscripts` int(11) DEFAULT NULL,
  `ip` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `port` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `referrer` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `useragent` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;
*/

?>
</body>
</html>