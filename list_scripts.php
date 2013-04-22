<?php session_start(); ?>
<html>
<head>
<head>
<title>deltasql - List database scripts</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
$deftz=ini_get('date.timezone');
if ($deftz=="") $deftz="Europe/Berlin";
date_default_timezone_set($deftz);

include("utils/utils.inc.php");
include("utils/display.inc.php");
include("utils/constants.inc.php");
include("utils/timing.inc.php");
$startwatch = start_watch();
include("head.inc.php");

if (isset($_SESSION['scriptsperpage'])) $scriptsperpage=$_SESSION['scriptsperpage']; else $scriptsperpage=$default_scriptsperpage;

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");

if (isset($_SESSION["userid"])) {
  $rights = $_SESSION["rights"];
  $sessionuserid = $_SESSION["userid"];
} else {
  $rights = 0; $sessionuserid="";
}  
if (isset($_SESSION["scriptoffset"])) { 
  $scriptoffset = $_SESSION["scriptoffset"];
} else {
  $scriptoffset=0;
  $_SESSION["scriptoffset"] = 0;
}

if (isset($_GET['textoutput'])) {
   $textoutput = $_GET['textoutput']; }
else $textoutput=0;
if (isset($_GET['textoutput'])) {
   $showall = $_GET['showall']; }
else $showall=0;

include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

  
// this is for search scripts capabilities
if (isset($_SESSION['search_title']))   $filtertitle=$_SESSION['search_title'];   else $filtertitle="";
if (isset($_SESSION['search_comments']))   $filtercomment=$_SESSION['search_comments']; else $filtercomment="";
if (isset($_SESSION['search_script']))   $filterscript=$_SESSION['search_script']; else $filterscript="";
if (isset($_SESSION['search_authorid']))   $authorid=$_SESSION['search_authorid']; else $authorid="";
if (isset($_SESSION['search_moduleid']))   $moduleid=$_SESSION['search_moduleid']; else $moduleid="";
if (isset($_SESSION['search_branchid']))   $branchid=$_SESSION['search_branchid']; else $branchid="";
if (isset($_SESSION['search_frmisaview']))   $frmisaview=$_SESSION['search_frmisaview']; else $frmisaview="";
if (isset($_SESSION['search_frmisapackage']))   $frmisapackage=$_SESSION['search_frmisapackage']; else $frmisapackage="";
if (isset($_SESSION['search_comments_matchcase']))   $commentsmatchcase=$_SESSION['search_comments_matchcase']; else $commentsmatchcase="";
if (isset($_SESSION['search_script_matchcase']))   $scriptsmatchcase=$_SESSION['search_script_matchcase']; else $scriptsmatchcase="";
if (isset($_SESSION['search_fromversion']))   $searchfromversion=$_SESSION['search_fromversion']; else $searchfromversion="";
if (isset($_SESSION['search_toversion']))   $searchtoversion=$_SESSION['search_toversion']; else $searchtoversion="";
if (isset($_SESSION['search_fromdata']))   $searchfromdata=$_SESSION['search_fromdata']; else $searchfromdata="";
if (isset($_SESSION['search_todata']))   $searchtodata=$_SESSION['search_todata']; else $searchtodata="";
if (isset($_SESSION['search_modified']))   $searchmodified=$_SESSION['search_modified']; else $searchmodified="";
   
   if (($filtertitle!="") || ($filtercomment!="") || ($filterscript!="") || ($authorid!="") || ($moduleid!="") || ($branchid!="") ||
       ($searchfromversion!="") || ($searchtoversion!="") || ($frmisaview!="") || ($frmisapackage!="") ||
       ($searchfromdata!="") || ($searchtodata!="") || ($searchmodified!=""))
   		echo "<b><a  href=\"search_cancel.php\">Cancel Search</a></b>";

echo "<br>";        

// concatenate the query
$query="";
if ($branchid!="") {
	$query="$query, tbscriptbranch sb ";
}
if ($commentsmatchcase==1) {
    //TODO: matchase query does not work, commented code is in place in search_scripts
    // to activate checkbox
    $query="$query WHERE (s.comments LIKE '%$filtercomment%') ";
} else {
        $query="$query WHERE (UPPER(s.comments) LIKE UPPER('%$filtercomment%')) ";
}

if ($filtertitle!="") {
        $query="$query and (s.title LIKE '%$filtertitle%')"; 
}

if ($filterscript!="") {
    if ($scriptsmatchcase==1) {
        //TODO: matchase query does not work, commented code is in place in search_scripts
        // to activate checkbox
        $query="$query and (UPPER(s.code) LIKE UPPER('%$filterscript%'))"; 
    } else {
        $query="$query and (s.code LIKE '%$filterscript%')"; 
    }
}
if ($authorid!="") {
	$query="$query and (s.user_id=$authorid)";
}
if ($moduleid!="") {
	$query="$query and (s.module_id=$moduleid)";
}
if ($branchid!="") {
	$query="$query and (s.id=sb.script_id) and (sb.branch_id=$branchid)";
}
if ($frmisaview!="") {
	$query="$query and (s.isaview=1)";
}
if ($frmisapackage!="") {
	$query="$query and (s.isapackage=1)";
}
if ($searchfromversion!="") {
	$query="$query and (s.versionnr >= $searchfromversion)";
}
if ($searchtoversion!="") {
	$query="$query and (s.versionnr <= $searchtoversion)";
}

if ($searchfromdata!="") {
	$query="$query and (s.create_dt >= '$searchfromdata')";
}
if ($searchtodata!="") {
	$query="$query and (s.create_dt <= '$searchtodata')";
}

if ($searchmodified!="") {
	$query="$query and (s.update_user IS NOT NULL)";
}

$querycount = "SELECT count(*) FROM tbscript s $query ";

if ($textoutput) {
   $query      = "$query ORDER BY versionnr ASC ";
} else {
   $query      = "$query ORDER BY versionnr DESC ";
}
if ($showall==0) $query="$query LIMIT $scriptoffset, $scriptsperpage ";
$query      = "SELECT * from tbscript s $query";

// decide if printing Next button
$resultcount=mysql_query($querycount);
if ($resultcount!="") {
 $nbscripts=mysql_result($resultcount,0,'count(*)');
} else $nbscripts=0;

if (($nbscripts>$scriptsperpage) && ($showall==0)) {
    if ($scriptoffset>0) {
      echo " <a href=\"script_top_page.php\">|<b>&#60;</b> First</a> ";
      echo " <a href=\"script_previous_page.php\"><b>&#60;&#60;</b> Previous</a> ";
    }
 
    $lastoffset=$nbscripts - ($nbscripts % $scriptsperpage);
    if ($scriptoffset<$lastoffset) {
	    echo " <b> </b> ";
        echo "<a href=\"script_next_page.php\">Next <b>&#62;&#62;</b></a> ";
        echo "<a href=\"script_last_page.php?nbscripts=$nbscripts\">Last <b>&#62;</b>|</a> ";
    }
    
}
   
echo "</p>";
echo "<hr>";
echo "<table border=\"1\">\n";


$result=mysql_query($query);   
$num=mysql_numrows($result); 

if ($textoutput==0) {
echo "<tr>
<th>version number</th>
<th>title</th>
<th>author</th>
<th>script</th>
<th>comments</th>
<th>module</th>
<th>branches</th>
<th>actions</th>
<th>view</th>
<th>package</th>
<th>create dt</th>
<th>update dt</th>
<th>update user</th>
</tr>";
}

$date=time();
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

if ($textoutput==0) {
    $scriptonlist = $script;
    if (strlen($script)>35) {
        $scriptonlist = substr($script, 0, 35);
        $scriptonlist = "$scriptonlist...";
    }

	if ($comments=="") $comments="-";
    if (strlen($comments)>10) {
        $comments = substr($comments, 0, 10);
        $comments = "$comments...";
    }
    if ($title=="") $title="db update";    
    $title = "<a href=\"show_script.php?id=$id&edit=1\">$title</a>";
}

$query3="SELECT * from tbuser where id=$scriptuserid"; 
$result3=mysql_query($query3);   
$author=mysql_result($result3, 0,  "username");
$email=mysql_result($result3, 0,  "email");

if (($email!="") && ($textoutput==0)) {
        $author = "<a href=\"mailto:$email\">$author</a>";
}

if ($textoutput==0) {
  if (isset($_SESSION['colorrows'])) $colorrows=$_SESSION['colorrows']; else $colorrows=$default_colorrows;
  if ($colorrows==1) color_row($date, $create_dt); else echo "<tr>";
  echo "
<td>$versionnr</td>
<td>$title</td>
<td>$author</td>
<td><pre>$scriptonlist</pre></td>
<td>$comments</td>
";
}

// retrieve module id name
$query2="SELECT * from tbmodule where id=$moduleid"; 
$result2=mysql_query($query2);   
$modulename=mysql_result($result2, 0,  "name");

if ($textoutput==0) {
 echo "<td> <b>$modulename</b> </td>";
}

if ($textoutput==0) {
    // retrieve to which branches and HEAD the script was applied
    $query3="SELECT * from tbscriptbranch sb, tbbranch b where (sb.script_id=$id) and (sb.branch_id=b.id) order by b.id asc"; 
    $result3=mysql_query($query3);   
    $num3=mysql_numrows($result3);
    $j=0;
    echo "<td>";
    while ($j <$num3) {  
    $branchname=mysql_result($result3,$j,"name");   
    echo " <b>$branchname</b> ";
    $j++;
    }
    echo "</td>";

    echo "
    <td><a href=\"show_script.php?id=$id&edit=1\"><img alt=\"Show\" src=\"icons/show.png\"></a> ";
	if ($rights>=1) {
        echo "<a href=\"edit_script.php?id=$id\"><img alt=\"Edit\" src=\"icons/edit.png\"></a> "; 
    }
	if ((($rights==1) && ($scriptuserid==$sessionuserid)) || ($rights>=2)) {
        $script_encoded = urlencode ( $script );
        $shortened=0;
        if (strlen($script_encoded)>100) { 
           $script_encoded = substr($script_encoded, 0, 100); 
           $shortened=1;
        }
  	  echo "<a href=\"delete_script_confirm.php?id=$id&version=$versionnr&script=$script_encoded&short=$shortened\"><img alt=\"Delete\" src=\"icons/delete.png\"></a> ";
	}
	if ($update_user!="") {
	    $author_encoded = urlencode ( $author );
	    echo "<a href=\"list_changelog.php?id=$id&version=$versionnr&author=$author_encoded\"><img alt=\"History\" src=\"icons/history.png\"></a>";
	} else {
	   $update_user="-";
	   $update_dt="-";
	}
    echo "</td>";
    echo "<td>$isaview</td><td>$isapackage</td>";
    echo "<td>$create_dt</td>
          <td>$update_dt</td>
          <td>$update_user</td>";
    echo "</tr>";
}

if ($textoutput==1) {
 echo "<p>";
 if ($title!="db update") {
    echo " -- title: <b>$title</b><br>";
 }
 echo " -- version: <b>$versionnr</b> date: <b>$create_dt</b> module: <b>$modulename</b>";
 echo "</p>";
 if ($comments!="") echo "<p><pre>/* $comments */</pre></p>";
 echo "<p><pre>$script</pre></p>";
}


$i++; // $i=$i+1;
}

mysql_close();
?>
</table>
<br>
<?php 
  echo "<h6>"; stop_watch($startwatch); echo "</h6>";
  include("bottom.inc.php");
?>
</body>
</html>
