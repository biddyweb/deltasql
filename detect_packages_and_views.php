<html>
<head>
<title>deltasql - Detect packages and views</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
$backto=$_GET['backto'];
?>
<h2>Detect packages and views</h2>

<p>By pressing submit on this page, you will execute a command which marks scripts as views if they contain the phrase <tt>CREATE OR REPLACE VIEW</tt> and which marks packages if the script contains the wording <tt>CREATE OR REPLACE PACKAGE</tt>.</p>

<p>
 <b>Note:</b> This command works reliably only if developers take care of submitting packages and views in their own scripts, separated from other alter table commands.
</p>

<form action="detect_packages_and_views.php" method="post">
<?php
echo "<input type=\"hidden\" name=\"submitted\"  value=\"1\">";
echo "<input type=\"hidden\" name=\"backto\"  value=\"$backto\">";
?>
<input type="Submit"> or 
<?php
if ($backto=="search")
    echo "<a href=\"search_scripts.php\">Cancel</a>";
 else
    echo "<a href=\"dbsync.php\">Cancel</a>";
?>
</form>


<?php
$submitted=$_POST['submitted'];
$frmbackto=$_POST['backto'];
if ($submitted!=1) exit;
include("conf/config.inc.php");
include("utils/utils.inc.php");

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="update tbscript set isapackage=1 where code like '%CREATE OR REPLACE PACKAGE%'";
mysql_query($query);

$query2="update tbscript set isaview=1 where code like '%CREATE OR REPLACE VIEW%'";
mysql_query($query2);

mysql_close();
if ($frmbackto=="search")
    js_redirect("search_scripts.php");
   else
    js_redirect("dbsync.php");
?>
</body>
</html>