<?php session_start(); ?>
<html> 
<head>
<title>deltasql - List branches and Tags </title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");
show_user_level();
if(isset($_SESSION['rights'])) {
  $rights = $_SESSION["rights"];
} else $rights=0;

?>
<h3>Project branches in blue and tags in yellow</h3>

<table border="1">
<?php
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbbranch ORDER BY id ASC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

echo "<tr>
<th>id</th>
<th>name</th>
<th>project</th>
<th>description</th>
<th>source branch</th>
<th>update dt</th>
<th>version number</th>
<th>visible</th>
<th>istag</th>
</tr>";

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$name=mysql_result($result,$i,"name");          
$description=mysql_result($result,$i,"description");
$create_dt=mysql_result($result,$i,"create_dt");
// exception for HEAD, we show something else, as in db the latest update version is saved
$versionnr=mysql_result($result,$i,"versionnr");
if ($name=="HEAD") $versionnr="always latest ($versionnr)"; 
$projectid=mysql_result($result,$i,"project_id");
$visible=mysql_result($result,$i,"visible");
$sourcebranch=mysql_result($result,$i,"sourcebranch");
$istag=mysql_result($result,$i,"istag");

$projectname="";
if ($projectid!="") {
  $query2="SELECT * from tbproject where id=$projectid"; 
  $result2=mysql_query($query2);
  if ($result2!="") $projectname=mysql_result($result2,0,'name');
}
// colouring tags and branches
if ($visible==1) {
   if ($istag==1) {
      echo "<tr BGCOLOR=\"#FDD017\">"; // yellow
   }
   else  {
	  echo "<tr BGCOLOR=\"#99CCFF\">"; // blue
   }	  
} else {
      echo "<tr>";
}  
echo "
<td>$id</td>
<td>$name</td>
<td>$projectname</td>
<td>$description</td>
<td>$sourcebranch</td>
<td>$create_dt</td>
<td>$versionnr</td>
<td>$visible</td>
<td>$istag</td>
<td>";
if (($rights>=2) && ($name!="HEAD")) {
    if ($visible==0) {
      echo " <a href=\"change_branch_visibility.php?id=$id&show=1\">Show</a> ";
    } else {
      echo " <a href=\"change_branch_visibility.php?id=$id&show=0\">Hide</a> ";
    }
    echo "<a href=\"edit_branch.php?id=$id\">Edit</a> ";
    if ($rights==3) {
	    $encoded_name=urlencode($name);
        echo " <a href=\"delete_branch_confirm.php?id=$id&name=$encoded_name&tag=$istag\">Delete</a> ";
    }    
}
if ($rights>=2) {
   if ($istag==0) {
	   echo "<a href=\"branch_again.php?id=$id&tag=0\">Branch</a> ";
	   echo "<a href=\"branch_again.php?id=$id&tag=1\">Tag</a> ";
   }	   
}
echo "</td>";

$i++; 
}
?>
</table>
<br>
<hr>
<form action="get_dev_tree_graph.php" method="post">
<?
// plotting project combobox
 echo "Project: <select NAME=\"frmprojectid\">";
 $query="SELECT * FROM tbproject ORDER BY name";
 $result=mysql_query($query);
 $num=mysql_numrows($result); 
 $i=0;
 while ($i<$num) { 
   $projectid=mysql_result($result,$i,"id");
   $projectname=mysql_result($result,$i,"name");
   echo "<option ";
   echo "VALUE=\"$projectid\">$projectname";
   $i++;
 }
 echo "</select> |";
 mysql_close();
?>
<input name="frmexcltag" type="checkbox" value="1">Exclude tags | 
<input type="Submit" value="Get tree graph">
</form>
<hr>
<a href="index.php">Back to main menu</a>
</body>
</html>
