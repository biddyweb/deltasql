<?php
include_once ("utils/constants.inc.php");
if (file_exists($configurationfile)) include_once ("conf/config.inc.php");
if (!isset($enterprise_edition)) $enterprise_edition=false;

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
    echo "<center>deltasql - Database Evolution under Control</center>";
}
echo "
</td>
</tr>
<tr>
<div align='left'>
<td>
<h4>Scripts</h4>
<ul>
";
if ($rights>0)
  echo "<li><a href=\"submit_script.php\">Submit Script</a></li>";
echo "<li><a href=\"list_scripts.php\">List Scripts</a> <a href=\"get_rss_feed.php\"><img src=\"pictures/rss-icon.png\" border=0/></a></li>";
if ($rights>2)
  echo "<br><li><a href=\"list_changelog_deleted.php\">View deleted</a></li>";
echo "</ul>";
  
echo "
</div>
</td>
<td>"; // the last <td> tag will be closed in bottom.inc.php

?>
