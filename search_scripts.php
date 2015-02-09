<?php session_start(); ?>
<html>
<head>
<title>deltasql - Search Scripts</title>

<style type="text/css">@import url(utils/jscalendar-1.0/calendar-win2k-1.css);</style>
<script type="text/javascript" src="utils/jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="utils/jscalendar-1.0/lang/calendar-en.js"></script>
<script type="text/javascript" src="utils/jscalendar-1.0/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
include("utils/components.inc.php");
include("head.inc.php");
if(isset($_SESSION['rights'])) {
  $rights = $_SESSION["rights"];
} else $rights=0;

// load current settings
if (isset($_SESSION['search_title'])) $cookie_filtertitle=$_SESSION['search_title']; else $cookie_filtertitle="";
if (isset($_SESSION['search_comments'])) $cookie_filtercomment=$_SESSION['search_comments']; else $cookie_filtercomment="";
if (isset($_SESSION['search_script'])) $cookie_filterscript=$_SESSION['search_script']; else $cookie_filterscript="";
if (isset($_SESSION['search_authorid'])) $cookie_authorid=$_SESSION['search_authorid']; else $cookie_authorid="";
if (isset($_SESSION['search_moduleid'])) $cookie_moduleid=$_SESSION['search_moduleid']; else $cookie_moduleid="";
if (isset($_SESSION['search_branchid'])) $cookie_branchid=$_SESSION['search_branchid']; else $cookie_branchid="";
if (isset($_SESSION['search_frmisaview'])) $cookie_frmisaview=$_SESSION['search_frmisaview']; else $cookie_frmisaview="";
if (isset($_SESSION['search_frmisapackage'])) $cookie_frmisapackage=$_SESSION['search_frmisapackage']; else $cookie_frmisapackage="";
if (isset($_SESSION['search_comments_matchcase'])) $cookie_commentsmatchcase=$_SESSION['search_comments_matchcase']; else $cookie_commentsmatchcase="";
if (isset($_SESSION['search_script_matchcase'])) $cookie_scriptsmatchcase=$_SESSION['search_script_matchcase']; else $cookie_scriptsmatchcase;
if (isset($_SESSION['search_fromversion'])) $cookie_fromversion=$_SESSION['search_fromversion']; else $cookie_fromversion="";
if (isset($_SESSION['search_toversion'])) $cookie_toversion=$_SESSION['search_toversion']; else $cookie_toversion="";
if (isset($_SESSION['search_fromdata'])) $cookie_fromdata=$_SESSION['search_fromdata']; else $cookie_fromdata="";
if (isset($_SESSION['search_todata'])) $cookie_todata=$_SESSION['search_todata']; else $cookie_todata="";
if (isset($_SESSION['search_modified'])) $cookie_modified=$_SESSION['search_modified']; else $cookie_modified="";
if (isset($_SESSION['search_projectid'])) $cookie_project=$_SESSION['search_projectid']; else $cookie_project="";
?>

<h2>Search Scripts</h2>
<form name="searchscripts" id="searchscripts" method="post" action="search_scripts_store_cookies.php">
<table>
<tr>
<td><b>Date Interval</b></td>
<td>
From:
<input type="text" id="fromdata" name="fromdata" value="<?php echo "$cookie_fromdata"; ?>" size="10">    
<button id="trigger_from">...</button>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "fromdata",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      button      : "trigger_from"       // ID of the button
    }
  );
</script>


To:
<input type="text" id="todata" name="todata" value="<?php echo "$cookie_todata"; ?>" size="10">    
<button id="trigger_to">...</button>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "todata",         // ID of the input field
      ifFormat    : "%Y-%m-%d",      // the date format
      button      : "trigger_to"      // ID of the button
    }
  );
</script>

</td> 
</tr>
<tr>
<td><b>Script Title:</b></td> <td><input type="text" name="title" 
                                           value="<?php echo "$cookie_filtertitle"; ?>" size="40">
</td>
</tr>
<td><b>Script Content:</b></td> <td><input type="text" name="script" 
                                           value="<?php echo "$cookie_filterscript"; ?>" size="40">
</td>
</tr>
<tr>
<td><b>Script Comments:</b></td> <td><input type="text" name="comments" 
                                            value="<?php echo "$cookie_filtercomment"; ?>" size="40">

 </td>
</tr>
<tr><td>
<b>Submitter:</b></td><td> 
<?php
 echo "<select NAME=\"authorid\">";
 echo "<option VALUE=\"\" ";
 if ($cookie_authorid=="") echo "SELECTED";
 echo ">";
 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 $query6="SELECT * FROM tbuser ORDER BY username";
 $result6=mysql_query($query6);
 $num6=mysql_numrows($result6); 
 
 // Author
 $i=0;
 while ($i<$num6) { 
   $authorid=mysql_result($result6,$i,"id");
   $authorname=mysql_result($result6,$i,"username");
   echo "<option VALUE=\"$authorid\" ";
   if ($cookie_authorid==$authorid) echo "SELECTED";
   echo ">$authorname";
   $i++;
 }
 echo "</select>";
 echo "</td></tr>";
 
 echo "<tr><td>";
 
 // Module
 echo "<b>Module</b>: </td> <td> <select NAME=\"moduleid\">";
 echo "<option VALUE=\"\" ";
 if ($cookie_moduleid=="") echo "SELECTED";
 echo ">";
 $query7="SELECT * FROM tbmodule ORDER BY name";
 $result7=mysql_query($query7);
 $num7=mysql_numrows($result7); 
 
 $i=0;
 while ($i<$num7) { 
   $moduleid=mysql_result($result7,$i,"id");
   $modulename=mysql_result($result7,$i,"name");
   echo "<option VALUE=\"$moduleid\" ";
   if ($cookie_moduleid==$moduleid) echo "SELECTED";
   echo ">$modulename";
   $i++;
 }
 echo "</select></td>";
 
 echo "</tr><tr>";
 
 // Project
 echo "<td><b>Project:</b></td><td>";
 printProjectComboBox($cookie_project);
 echo "</td></tr><tr>";
 //Branch
 echo "<td><b>Branch:</b></td> ";
 echo "<td><select NAME=\"branchid\">";
 echo "<option VALUE=\"\" ";
 if ($cookie_branchid=="") echo "SELECTED";
 echo ">";
 $query8="SELECT * FROM tbbranch WHERE istag=0 order by name ASC";
 $result8=mysql_query($query8);
 $num8=mysql_numrows($result8); 
 $i=0;
 while ($i<$num8) { 
   $branchid=mysql_result($result8,$i,"id");
   $branchname=mysql_result($result8,$i,"name");
   echo "<option VALUE=\"$branchid\" ";
   if ($cookie_branchid==$branchid) echo "SELECTED";
   echo ">$branchname";
   $i++;
 }
 echo "</select></td></tr>";
 
 echo "<tr>";
 echo "<td><b>Particular script:</b></td>";
 echo "<td><input name=\"frmisaview\" type=\"checkbox\" value=\"1\" ";
 if ($cookie_frmisaview==1) echo "checked=\"checked\"";
 echo "/>View";
 echo "<input name=\"frmisapackage\" type=\"checkbox\" value=\"1\" ";
 if ($cookie_frmisapackage==1) echo "checked=\"checked\"";
 echo "/>Package</td>";
 if ($rights>1)
     echo "<td><a href=\"detect_packages_and_views.php?backto=search\">Detect views and packages</a></td>";
 echo "</tr>";

 mysql_close();
?>
<tr>
<td><b>Version number</b></td> 
<td>From: <input type="text" name="fromversion" value="<?php echo "$cookie_fromversion"; ?>" size="10">
 To: <input type="text" name="toversion" value="<?php echo "$cookie_toversion"; ?>" size="10"></td>
</td>

<?php
 echo "<tr>";
 echo "<td><b>Modified scripts only:</b></td>";
 echo "<td><input name=\"frmmodified\" type=\"checkbox\" value=\"1\" ";
 if ($cookie_modified=="1") echo "checked=\"checked\"";
 echo "/> </td>";
 echo "</tr>";

 echo "<td><b>Output as a text list:</b></td>";
 echo "<td><input name=\"frmtextlistoutput\" type=\"checkbox\" value=\"1\" ";
 echo "/> (from lowest version to highest)</td>";
 echo "</tr>";
?>
<tr>
<td></td>
<td>
<input type="Submit" value="Search among Scripts">
</td>
<td></td>
</tr>
</table>
</form>
<?php include("bottom.inc.php"); ?>
</body>
</html>
