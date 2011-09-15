<?php session_start(); ?>
<html>
<head>
<title>deltasql - Database Evolution under Control</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>

<?php 
 include("head.inc.php");
 include("utils/constants.inc.php");
 include("utils/utils.inc.php");
 include("patch/patchlevel.inc.php");
 
 if (file_exists($configurationfile)) {
    include("conf/config.inc.php");
 } 
 if (!isset($disable_clients_table_on_main_page))  $disable_clients_table_on_main_page= false;
 if (!isset($dns_name)) $dns_name="";
 
 if (file_exists($configurationfile)) show_user_level();
 if(isset($_SESSION['userid'])) {
    $rights = $_SESSION["rights"];
    $user = $_SESSION["username"];
 } else {
   $rights=0; $user=""; 
 }
 
 echo "<h2>deltasql server $deltasql_version";
 if ($patchlevel!="") echo "-$patchlevel";
 echo "</h2>";
?>


<p>
<?php
if (file_exists($configurationfile)) {
    // showing date and hour of latest changes
    echo "Last Update: ";
    mysql_connect($dbserver, $username, $password);
    @mysql_select_db($database) or die("Unable to select database");
    $query3="SELECT create_dt FROM `tbbranch` where name='HEAD'";
    $result3=mysql_query($query3);
    $create_dt=mysql_result($result3,0,'create_dt');
    echo "<b>$create_dt</b>";
	
	// checking if the database schema is uptodate
	$query4="SELECT tagname FROM `tbsynchronize` where versionnr=(select max(versionnr) FROM tbsynchronize);";
    $result4=mysql_query($query4);
    $tagname=mysql_result($result4,0,'tagname');
	
	if  ((!$test_system) && ($tagname!="TAG_deltasql_$ds_schema_version")) {
	      if ($tagname=="") $tagname="TAG_deltasql_1.3.?";
	      echo "<p><b><font color=\"red\">Deltasql database schema needs to be upgraded! The database needs to be tagged with TAG_deltasql_$ds_schema_version.</b></font></p>";
		  echo "<p>Please visit the <a href=\"http://www.deltasql.org/deltasql/dbsync.php\">synchronization page on deltasql.org</a>, ";
		  echo " set as parameters <b>Project Name: deltasql-Server</b>, <b>From: $tagname</b>, <b>Update To: TAG_deltasql_$ds_schema_version</b>, leave the <b>Version Number:</b> field empty ";
		  echo " and hit the synchronization button at the bottom. Then execute the generated script into the deltasql schema to solve this issue. </p>";
		  
		  echo "<p>If you are developing deltasql or you patched it, you might want to disable this error by setting the <b>test_system</b> variable in  ";
		  echo "<i>$configurationfile</i> to true.";
		  
		  mysql_close();
		  die("<p><b><font color=\"red\">FATAL ERROR: datamodel mismatch for database '$database' on host '$dbserver'.</font></b></p>");	
	}
	
    mysql_close();
 } else {
    echo "<h2><a href=\"install.php\">$installmessage</a></h2>";
 } 
?>

<table cellspacing="4" cellpadding="4">
<tr>
<td valign="top">

</p>
<h3>SQL Scripts</h3>
<ul>
<?php
if ($rights>0)
  echo "<li><a href=\"submit_script.php\">Submit Script</a></li>";
echo "<li><a href=\"list_scripts.php\">List Scripts</a> <a href=\"get_rss_feed.php\"><img src=\"pictures/rss-icon.png\" border=0/></a></li>";
if ($rights>2)
  echo "<li><a href=\"list_changelog_deleted.php\">View deleted</a></li>";
?>
</ul>

</td>
<td valign="top">
<h3>Modules</h3>
<ul>
<?php
if ($rights>1)
    echo "<li><a href=\"create_module.php\">Create Module</a></li>";
?>
<li><a href="list_modules.php">List Modules</a></li>
</ul>
</td>

<td valign="top">
<h3>Projects</h3>
<ul>
<?php
if ($rights>1)
    echo "<li><a href=\"create_project.php\">Create a Project</a></li>";
?>
<li><a href="list_projects.php">List Projects</a></li>
</ul>
</td>

<td valign="top">
<h3>Synchronization</h3>
<ul>
<li><a href="list_branches.php">List Branches and Tags</a></li>
<li><a href="dbsync.php">Synchronize database schema</a></li>
<?php 
if ($rights>2) 
    echo "<br><li><a href=\"list_usage_history.php\">List Usage History</a></li>";
?>
</ul>
</td>


<td valign="top">
<h3>Users</h3>
<ul>
<?php 
if (($rights>0) && (!$disable_topten_submitters)) {
    echo "<li><a href=\"topten_submitters.php\">Top Ten Submitters</a></li><br>";
}

if ($rights>2) 
    echo "<li><a href=\"insert_user.php\">Create User</a></li>";
if ($rights>1) 
    echo "<li><a href=\"list_users.php\">List Users</a></li>";

?>
<?php 

if ($rights==0)
  echo "<li><a href=\"login.php\">Login</a></li>"; 
if ($rights>0) {
    echo "<li><a href=\"change_password.php\">Change Password</a></li>";
    echo "<li><a href=\"logout.php\">Logout</a></li>";
}
?>
</ul>
</td>
<td>
<h3>Help</h3>
<ul>
<li><a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/" target=_blank>Tutorials (movies)</a></li>
<li><a href="manual.php">Manual</a></li>
<li><a href="faq.php">FAQ</a></li>
<?php
if ($enterprise_edition==false) {
    echo "<li><a href=\"http://www.deltasql.org/wiki/\" target=_blank>Wiki</a></li>";
    if ($rights==3) echo "<li><a href=\"mailto:gpu-world AT lists.sourceforge.net\">Mailing list</a></li>";
	if ($rights==3) echo "<li><a href=\"http://www.ohloh.net/p/deltasql\" target=_blank>Ohloh metrics</a></li>";
	echo "<li><a href=\"http://sourceforge.net/projects/deltasql/\" target=_blank>Project Page</a></li>";
} else {
    echo "<li><a href=\"$enterprise_website\">$enterprise_name</a></li>";
}

if ($rights==3) {
        echo "<li><a href=\"phpinfo.php\">PHP Version Info</a></li>";
}
?>
</ul>
</td>
</table>

<?php
 if ($disable_clients_table_on_main_page==true) {
    // do nothing
 } else {
    include("download_clients_table.inc.php");
 }
?>

<h3>Database Evolution Under Control</h3>

<h6>(how deltasql works)</h6>
<p>
A strong version control system for databases saves time to developers, who would like to keep their schema updated while developing with minimal effort. 
With a version control for databases, the number of mistakes dued to different schemas or missing scripts is considerably reduced. Critical errors in production due to schema
 inconsistencies disappear, too.
</p>
<p>
deltasql is an Open Source tool to synchronize databases with source code.
While developing middle size or big applications, developers undertake changes to the data model which go along with changes to the source code. From time
  to time, branches of source code are done to stabilize the code which will go to production. A sort of data model branch is also needed.
</p>
<p>  
deltasql provides a simple set of php scripts to be executed on an apache server backed by a mySQL database to collect all scripts which change the data model, and means to handle 
data model branches. The trick is to number the sql scripts and to create on each database instance a table which keeps the number of the latest executed script 
(the table deltasql uses is named TBSYNCHRONIZE). 
</p>
<p> 
 A <a href="dbsync.php">form</a> allows the user to enter data from the synchronization table and thereafter the needed chain of datamodel updates is computed and shown to the user. The user
 has to manually execute all scripts. It is possible to update development schemas (the HEADs) and production schemas (the branches), to transform a production schema into a development schema and
 vice versa. Also in case of a schema dumped and imported into another database, it is still upgradeable as the synchronization table
 is contained into the copyed schema. However, it is not possible to downgrade a schema back to a previous version. 
</p>
<p> 
 There are deltasql clients (listed in the table above), which automatically collect synchronization data from a given database schema.
 Though deltasql works best with Oracle, PostgreSQL and mySQL schemas, any other database type can use most of deltasql functionality.
</p>

<?php
if ($enterprise_edition==true)
  echo "<img src=\"pictures/deltasql-small.png\" border=0";
?>
<h6>deltasql is Open Source under <a href="docs/GPL_license.txt">GPL</a> (source code <a href="http://sourceforge.net/projects/deltasql/">here</a>) and is developed
 and mantained by the <a href="http://sourceforge.net/project/memberlist.php?group_id=212117">deltasql Team</a>. 
 The deltasql logo was designed by 
<?php 
 if ($enterprise_edition==false) {
   echo "<a href=\"patrizia.php\">Patrizia Pulice Cascio</a>. ";
 } else {
   echo "Patrizia Pulice Cascio. ";
 } 
 echo "The changelog is <a href=\"docs/ChangeLog.txt\">here</a>. ";
 if ($patchlevel!="") {
    echo "A description of the applied patch is <a href=\"patch/description.txt\">here</a>.";
 }	
 echo "</h6>";
 echo "</center>";
 
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
?> 
 
</body>
</html>
