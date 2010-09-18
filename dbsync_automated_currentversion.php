<?php
include("utils/utils.inc.php");
include("conf/config.inc.php");

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

include("dbsync_currentversion.inc.php");
$projectname  = $_GET['project'];
$version = dbsynccurrentversion($projectname, -1, 1);

echo "\n";
echo "project.name= $projectname\n";
echo "project.version = $version\n";

 mysql_close();

?>
