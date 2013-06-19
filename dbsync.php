<?php session_start(); ?>
<html>
<head>
<title>deltasql - Database Synchronization Form</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<script language="javascript"  type="text/javascript" src="validation.js"></script>
<script language="javascript" type="text/javascript">
	function getBranches(id)
	{
		var obj = document.syncform;
		if (id != "")
		{
			url = "ajax_get_branches.php?projectid="+id;
			http.open("GET", url, true);
			http.onreadystatechange = getBranchesResponse; 
			http.send(null);
			
		}
	}
	
	function getBranchesResponse()
	{
		//alert(http.readyState);
		var obj = document.syncform;
		if (http.readyState == 4)
		{
			var result = trimString(http.responseText);
			if (result != '' && result != 'undefined')
			{
				clearBox(obj.frombranchid);
                clearBox(obj.tobranchid);
				var result_line_arr = result.split("###");
				for (i=0;i<result_line_arr.length;i++)
				{
					var result_arr = result_line_arr[i].split(":");
					var code = result_arr[0];
					var name = result_arr[1];
					obj.frombranchid.options[i] = new Option(name, code);
                    obj.tobranchid.options[i] = new Option(name, code);
				}
			}		
		}
	}
</script>
</head>
<body>
<?php
include("utils/constants.inc.php");
include("utils/copypaste.inc.php");
include("utils/components.inc.php");

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");
include("conf/config.inc.php");
include("utils/utils.inc.php");

if(isset($_SESSION['rights'])) {
  $rights = $_SESSION["rights"];
  $user = $_SESSION["username"];
  $userid = $_SESSION["userid"];
} else {
  $rights=0; $user=""; $userid="";
}

if (isset($_GET["id"])) {
   $defaultprojectid = $_GET["id"];
}   
else {
   // attempt to retrieve default project from cookies :-)
   if (isset($_SESSION["dbsync_projectid"])) 
      $defaultprojectid = $_SESSION["dbsync_projectid"];
   else $defaultprojectid = "";	  
}

if (!isset($default_copypaste)) $default_copypaste=1;
printCopyPasteJS($default_copypaste);
include("head.inc.php");

?>

<h2>Database Synchronization Form</h2>

<p>1) First, make sure your database schema has a table called TBSYNCHRONIZE. If not, click on the <a href="list_projects.php">
project list</a> and press on the 'Table' link, this will generate a script you have to launch on your database schema.
</p>
<p>2) You should run the following query into the database instance you would like
to synchronize, and then fill the form below with the query's results as explained in the italic comments</p>
<?php
echo "<tt>";
echo "<p id='clipboard_text'>select * from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);</p>";
echo "</tt>";
echo "<center>";
printCopyPasteLink("Copy this query to clipboard", 0, $default_copypaste);
echo "</center>";

?>
<p>3) Please enter the synchronization details you retrieved from the query:</p>

<form name="syncform" action="dbsync_update.php" method="post">
<?php
 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 
 echo "<table>";
 echo "<tr><td><b>Project Name:</b></td><td>";
 printProjectComboBox($defaultprojectid, 'onchange="javascript: getBranches(this.value);"');
 echo "</select>";
 echo "</td><td><i>= value in column projectname</i></td></tr>";
 
 echo "<tr><td><b>Version Number:</b></td>";
 echo "<td><input type=\"text\" name=\"lastversionnr\" value=\"\"></td><td><i>= value in column versionnr</i></td></tr>";
 
 echo "<tr><td><b>From:</b></td>";
 echo "<td>";
 
 echo "<select NAME=\"frombranchid\">";
 echo "</select></td><td><i>= value in column branchname or tagname</i></td></tr>";
 
 echo "<tr><td><b>Update To:</b></td>";
 echo "<td>";
 echo "<select NAME=\"tobranchid\">";
 echo "</select>";
 echo "</td><td><i>= HEAD if schema has to include all scripts or another branch name if not</i></td></tr>";
 
 echo "</tr>";
 echo "<tr><td><b>Database Type:</b></td><td>";
 printDatabaseComboBox($dbdefault);
 echo "</td><td><i>= value in column dbtype</i></td></tr>";

 if ($rights>1) {
   echo "<td><b>Exclude:</b></td>";
   echo "<td><input name=\"frmexcludeviews\" type=\"checkbox\" value=\"1\"/>Views";
   echo "<input name=\"frmexcludepackages\" type=\"checkbox\" value=\"1\"/>Packages</td>";
   echo "<td>";
   echo "<a href=\"detect_packages_and_views.php\">Detect views and packages</a></td>";
 }
 echo "</td></tr>";
 
 
 echo "<tr><td><b>Output Format:</b> </td>";
 echo "<td>";
 echo "<input type=\"radio\" name=\"formatgroup\" value=\"html\" checked> HTML";
 echo "<input type=\"radio\" name=\"formatgroup\" value=\"text\"> Text";
 echo "<input type=\"radio\" name=\"formatgroup\" value=\"xml\"> XML";
 echo "<input type=\"radio\" name=\"formatgroup\" value=\"singlefiles\"> Single files (zipped)";
 echo "</td></tr>";
  
 echo "<tr><td><b>Debug:</b> </td>";
 echo "<td><input name=\"frmdebug\" type=\"checkbox\" value=\"1\"/>Include debug information";
 echo "</td></tr>"; 
 echo "</table><br><br>";
 mysql_close();
?>
<b>4) Please copy and execute in a sql client (like SqlPlus or Toad or PhpMyAdmin) the script you
 will receive after pressing the button below!<br> This will update both your database schema and the
  synchronization information in table TBSYNCHRONIZE.</b><br><br>
 
<center><input type="Submit" value="Generate Synchronization Script"></center>
</form>
<br>
<?php
 if ($defaultprojectid!="") {
  echo "
   <script type='text/javascript'>
    getBranches($defaultprojectid);
   </script>
   ";
 } 
?>
<?php
if (isset($_SESSION['displayhelplinks'])) $displayhelp=$_SESSION['displayhelplinks']; else $displayhelp=$default_displayhelplinks;
if ($displayhelp==1)  
   echo '<a href="manual.php#syncworks"><img src="icons/help.png"> How synchronization works with examples</a><br>';
?>
<?php
include("bottom.inc.php");
printCopyPasteBlock("select * from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);", $default_copypaste);

?>


</body>
</html>
