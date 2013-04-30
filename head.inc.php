<?php
include_once ("utils/constants.inc.php");
if (file_exists($configurationfile)) include_once ("conf/config.inc.php");
if (!isset($enterprise_edition)) $enterprise_edition=false;
if (!isset($dns_name)) $dns_name="";
if (!isset($enable_server_stats)) $enable_server_stats=false;
if (!isset($disable_topten_submitters)) $disable_topten_submitters=true;

 if(isset($_SESSION['rights'])) {
    $rights = $_SESSION["rights"];
    $user = $_SESSION["username"];
 } else {
   $rights=0; $user=""; 
 }

echo "
<table>
<tr>
<td>
<a href=\"index.php\"><img src=\"pictures/deltasql-small.png\" alt=\"logo\" border='0' /></a>
</td>
<td>
";

if ($enterprise_edition==true) {
echo " 
    <center>
      <a href=\"index.php\"><img src=\"$enterprise_logo\" alt=\"logo\" border='0' /></a>
    </center>
";
} else { 
    echo "<center><h3>deltasql - Database Evolution under Control</h3></center>";
	if ($dns_name=="http://deltasql.sourceforge.net/deltasql") echo "<center><a href='../index.php'>Back to Website</a></center>";
}
echo "
</td>
</tr>
<tr>
<div align='left'>
<td>
<h3>Navigation Bar</h3>
";

echo "<ul>";
echo "<li><a  href=\"index.php\"><img src=\"icons/home.png\"> Main</a></li>";
echo "<li><a  href=\"clients.php\">Clients</a></li>";
echo "</ul>";

echo "
<h3>Scripts</h3>
<ul>
";
if ($rights>0)
  echo "<li><a href=\"submit_script.php\"><img src=\"icons/new.png\"> Submit</a></li>";
echo "<li><a href=\"list_scripts.php\"><img src=\"pictures/rss-icon.png\" border=0/> List</a></a></li>";
if ($dns_name!="") echo "<li><a  href=\"search_scripts.php\"><img src=\"icons/search.png\"> Search</a></li>";
echo "</ul>";

echo "
<h3>Modules</h3>
<ul>
";
if ($rights>1)
    echo "<li><a href=\"create_module.php\">Create</a></li>";
echo "<li><a href=\"list_modules.php\">List</a></li>";
echo "</ul>";

echo "
<h3>Projects</h3>
<ul>";
if ($rights>1)
    echo "<li><a href=\"create_project.php\">Create</a></li>";
echo "<li><a href=\"list_projects.php\">List</a></li><br>";
echo "</ul>";

echo "
<h3>Synchronization</h3>
<ul>
<li><a href=\"list_branches.php\"><img src=\"icons/tree.png\"> List</a></li>
<li><a href=\"dbsync.php\"><img src=\"icons/show2.png\"> Synchronize</a></li>
</ul>
";

echo "
<h3>Statistics</h3>
<ul>";
if ($enable_server_stats) echo "<li><a href=\"server_stats.php\">Server</a></li>";      
if (!$disable_topten_submitters) {
    echo "<li><a href=\"topten.php\">Top Ten</a></li><br>";
}
echo "</ul>";


echo "
<h3>Users</h3>
<ul>
";
if ($rights>2) 
    echo "<li><a href=\"insert_user.php\">Create</a></li>";
if ($rights>1) {
    echo "<li><a href=\"list_users.php\">List</a></li>";
}	

if ($rights==0)
  echo "<li><a href=\"login.php\"><img src=\"icons/rights.png\"> Login</a></li>"; 
if ($rights>0) {
    echo "<li><a href=\"preferences.php\"><img src=\"icons/settings.png\"> Preferences</a></li>";
    echo "<li><a href=\"logout.php\"><img src=\"icons/logout.png\"> Logout</a></li>";
}
echo "</ul>";

echo "
<h3>Help</h3>
<ul>
<li><a href=\"faq.php\">FAQ</a></li>
<li><a href=\"manual.php\">Manual</a></li>
</ul>
";
  
echo "
</div>
</td>
<td>"; // the last <td> tag will be closed in bottom.inc.php

?>
