<html>
<head>
<title>deltasql - Latest Scripts</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
//echo "<style type=\"text/css\">";
//include ("deltasql_gadget.css");
//echo "</style>";
include("utils/utils.inc.php");
include("utils/constants.inc.php");

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");

$rights = 1;

$scriptoffset=0;
$scriptsperpage = $_GET["up_numentries"];
$fontsize       = $_GET["up_fontsize"];
if ($scriptsperpage=="") $scriptsperpage=10;
if ($fontsize  =="") $fontsize=2;

if ($maxentries > 30)   {                                                                          
         echo("<b>Too many scripts (max is 30).</b><br>");                  
         $scriptsperpage = 10;                                                          
} 
if ($scriptsperpage < 1)  {                                                                          
         echo("<b>At least one script has to be shown.</b><br>");                  
         $scriptsperpage = 10;                                                          
}

if (($fontsize < 1) || ($fontsize>4)) {                                                                          
         echo("<b>Font size has to be between 1 and 4.</b><br>");                  
         $fontsize=2;                                                          
} 


$textoutput=0;
$showall=0;
?>
<?php
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

echo "<font size=\"$fontsize\">";
?>


<img src="pictures/deltasql-small.png" border="0" />
<a href="list_scripts.php" target=_blank>List</a> <a href="dbsync.php" target=_blank>Sync</a>
<a href="faq.php" target=_blank>FAQ</a> <a href="manual.php" target=_blank>Manual</a> 
<a href="server_stats.php" target=blank">Stats</a> 
 <?php
echo "Version: <a 
href='http://deltasql.sourceforge.net/deltasql/docs/ChangeLog.txt' 
target=_blank>$deltasql_version</a>";
?>
 <a href='http://sourceforge.net/project/memberlist.php?group_id=212117' target=_blank>Team</a>
<br>
<?php
echo "</font>";
?>
<table border="1">
<?php
// concatenate the query
$query      = "select * from tbscript ORDER BY versionnr DESC LIMIT 0, $scriptsperpage";

$result=mysql_query($query);   
$num=mysql_numrows($result); 

echo "<tr>
<th><font size=\"$fontsize\">ver.</font></th>
<th><font size=\"$fontsize\">title</font></th>
<th><font size=\"$fontsize\">submitter</font></th>";
//<th><font size=\"$fontsize\">script</font></th>
//<th><font size=\"$fontsize\">comments</font></th>
echo "
<th><font size=\"$fontsize\">module</font></th>
<th><font size=\"$fontsize\">branches</font></th>";
//<th><font size=\"$fontsize\">actions</font></th>
//<th><font size=\"$fontsize\">view</font></th>
//<th><font size=\"$fontsize\">package</font></th>
echo "<th><font size=\"$fontsize\">create dt</font></th>";
//<th><font size=\"$fontsize\">update dt</font></th>
//<th><font size=\"$fontsize\">update user</font></th>
echo "</tr>";

$date = time();

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$title=htmlentities(mysql_result($result,$i,"title"));           
$comments=htmlentities(mysql_result($result,$i,"comments"));
$create_dt=mysql_result($result,$i,"create_dt");
$update_dt=mysql_result($result,$i,"update_dt");
$update_user=mysql_result($result,$i,"update_user");
$versionnr=mysql_result($result,$i,"versionnr");
$moduleid=mysql_result($result,$i,"module_id");
$scriptuserid=mysql_result($result,$i,"user_id");
$script=htmlentities(mysql_result($result,$i,"code"));
$isaview=mysql_result($result,$i,"isaview");
$isapackage=mysql_result($result,$i,"isapackage");

    $scriptonlist = $script;
    if (strlen($script)>35) {
        $scriptonlist = substr($script, 0, 35);
        $scriptonlist = "$scriptonlist<b>...</b>";
    }

    if (strlen($comments)>10) {
        $comments = substr($comments, 0, 10);
        $comments = "$comments<b>...</b>";
    }
    if ($title=="") $title = "db update";    
    $title = "<a href=\"show_script.php?id=$id\" target=_blank>$title</a>";

$query3="SELECT * from tbuser where id=$scriptuserid"; 
$result3=mysql_query($query3);   
$author=mysql_result($result3, 0,  "username");
$email=mysql_result($result3, 0,  "email");

if ($email!="")  {
        $author = "<a href=\"mailto:$email\">$author</a>";
}

color_row($date, $create_dt);
echo"<td><font size=\"$fontsize\">$versionnr</font></td>
<td><font size=\"$fontsize\">$title</font></td>
<td><font size=\"$fontsize\">$author</font></td>";
//<td><font size=\"$fontsize\"><pre>$scriptonlist</pre></font></td>
//<td><font size=\"$fontsize\">$comments</font></td>

// retrieve module id name
$query2="SELECT * from tbmodule where id=$moduleid"; 
$result2=mysql_query($query2);   
$modulename=mysql_result($result2, 0,  "name");

 echo "<td><font size=\"$fontsize\"><b>$modulename</b></font> </td>";

    // retrieve to which branches and HEAD the script was applied
    $query3="SELECT * from tbscriptbranch sb, tbbranch b where (sb.script_id=$id) and (sb.branch_id=b.id) order by b.id asc"; 
    $result3=mysql_query($query3);   
    $num3=mysql_numrows($result3);
    $j=0;
    echo "<td>";
    while ($j <$num3) {  
    $branchname=mysql_result($result3,$j,"name");   
    echo "<font size=\"$fontsize\"> <b>$branchname</b></font> ";
    $j++;
    }
    echo "</td>";

    echo "<td><font size=\"$fontsize\">$create_dt</font></td>";
    echo "</tr>";


$i++; // $i=$i+1;
}

mysql_close();
?>
</table>
<br>
<?php
//<script type="text/javascript">
//gadgets.window.adjustHeight();
//</script>
?>
</body>
</html>

