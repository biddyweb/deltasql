<?php
// this php script is used only by deltasql.org
include("conf/config.inc.php");
include("usage_stats.inc.php");

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$ip               = $_SERVER['REMOTE_ADDR'];
$nbscripts        = $_GET['nbscripts'];
$nbmodules        = $_GET['nbmodules'];
$nbprojects       = $_GET['nbprojects'];
$nbbranches       = $_GET['nbbranches'];
$nbsyncs          = $_GET['nbsyncs'];
$nbusers          = $_GET['nbusers'];
$nnmp             = $_GET['nbmp'];
$nbsb             = $_GET['nbsb'];
$deltasql_version = $_GET['version'];

answer_phone($ip, $nbscripts, $nbmodules, $nbprojects, $nbbranches, $nbsyncs, $nbusers, $nnmp, $nbsb, $deltasql_version);

mysql_close();

?>