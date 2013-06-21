<?php session_start(); ?>
<html>
<head>
<title>deltasql - Submit database script</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<script language="javascript"  type="text/javascript" src="validation.js"></script>
<script type="text/javascript">
<!--
function SetAllBranches(CheckValue)
{
	var objCheckBoxes = document.scriptform.branchset.elements;
	// set the check value for all check boxes
	for(var i = 0; i < objCheckBoxes.length; i++) {
		var obj = objCheckBoxes[i];
		if (obj.name.indexOf('BRANCH_') >= 0) {
			obj.checked = CheckValue;
		}
	}
}

function RemoveEmptyLines() {
  var text = document.forms['script'].elements['script'].value;
  text = text.replace(/\n\n/g, "\n");
  document.forms['script'].elements['script'].value = text;  
  alarm(text);
}


    function getBranchesCheckList(moduleid)
	{
        var obj = document.scriptform;
		if (moduleid != "")
		{
			url = "ajax/get_branches_with_module.php?moduleid="+moduleid;
			http.open("GET", url, true);
			http.onreadystatechange = getBranchesResponseCheckList; 
			http.send(null);
        }
	}
	
	function getBranchesResponseCheckList()
	{
		if (http.readyState == 4)
		{
			var result = trimString(http.responseText);
			if (result != '' && result != 'undefined')
			{
                var checkboxes = document.scriptform.branchset.getElementsByTagName('input');
                var labels     = document.scriptform.branchset.getElementsByTagName('label');
                
                // removing previous checkboxes
                // we start from the end!!
                length = checkboxes.length;
                while(length--) {
                    var remElm = checkboxes[length];   // element to be removed
                    document.scriptform.branchset.removeChild(remElm);
                    
                    var labElm = labels[length];
                    document.scriptform.branchset.removeChild(labElm);
                }
                
				var result_line_arr = result.split("###");
				for (i=0;i<result_line_arr.length;i++)
				{
					var result_arr = result_line_arr[i].split(":");
					var code = result_arr[0];
					var name = result_arr[1];
					
                    
                    var checkbox = document.createElement('input');
                    checkbox.type = "checkbox";
                    checkbox.name =  "BRANCH_"+code;
                    if (name!="HEAD") {
                        checkbox.checked=false;
                    } else {
                        checkbox.checked=true;
                    }
                    //checkbox.id =  "BRANCH_"+code;
                    
                    var newlabel = document.createElement("label");
                    newlabel.setAttribute("for",i);
                    newlabel.innerHTML = name;
                    
                    document.scriptform.branchset.appendChild(checkbox);
                    document.scriptform.branchset.appendChild(newlabel);
				}
                //alert('Over');    
			}	
                    
		}
	}
// -->
</script>
</head>
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");
include("utils/sendmail.inc.php");
//show_user_level();
$rights = $_SESSION["rights"];

// this does not seem to work on all Apache instances
//$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<1) die("<b>Not enough rights to insert a new database script.</b>");

 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");

 // checking if there is at least one module, if not print an error message and exit
 $query44="SELECT count(*) FROM tbmodule";
 $result44=mysql_query($query44);
 $modcount=mysql_result($result44,0,"count(*)");
 if ($modcount==0) {
     mysql_close();
	 die("<b><font color=\"red\">You need to create at least one module before submitting scripts.</font></b>");
 }

?>
<h2>Insert a New Database Script</h2>
<form name="scriptform" action="submit_script_execution.php" name="script" method="post">
<table>
<tr>
<td>Title:</td>
<td><input type="text" name="title" value="<?php echo "$default_script_title"; ?>" size="120"></td>
</tr>
<tr>
<td>Author:</td> 
<?php
 // retrieving user name from user id
 // necessary because some old Apaches have problems with the username (why?)
 $query33="SELECT username FROM tbuser WHERE id=$userid";
 $result33=mysql_query($query33);
 $user = mysql_result($result33, 0, "username");

 echo "<td><b>$user</b></td>";
?>
</tr>
<tr>
<td>Module:</td>
<td>
<?php
 echo "<select NAME=\"frmmoduleid\" onchange=\"javascript: getBranchesCheckList(this.value);\">";
 echo "<option SELECTED VALUE=\"\">";

 $query6="SELECT * FROM tbmodule ORDER BY name asc";
 $result6=mysql_query($query6);
 $num6=mysql_numrows($result6); 
 
 $i=0;
 while ($i<$num6) { 
   $moduleid=mysql_result($result6,$i,"id");
   $modulename=mysql_result($result6,$i,"name");
   echo "<option VALUE=\"$moduleid\">$modulename";
   $i++;
 }
 echo "</select></td></tr>";

 echo "\n<tr><td>Apply script to:<br>";
 echo "<a onclick=\"SetAllBranches(true);\">all</a> .:. <a onclick=\"SetAllBranches(false);\">none</a></td><td>";
 
 $query7="SELECT * FROM tbbranch WHERE visible=1 AND istag=0 order by name ASC";
 $result7=mysql_query($query7);
 $num7=mysql_numrows($result7); 
 
 
 echo "<fieldset name='branchset'><legend>Branches:</legend>";
 echo "</fieldset>";
 
 echo "</td>";
 echo "</tr>";
 
 echo "<tr>";
 echo "<td>Particular script (optional):</td>";
 echo "<td><input name=\"frmisaview\" type=\"checkbox\" value=\"1\"/>View";
 echo "<input name=\"frmisapackage\" type=\"checkbox\" value=\"1\"/>Package</td>";
 echo "</tr>";
 
 mysql_close();
?>

</table>
Script: <a onclick="RemoveEmptyLines();">Remove empty lines</a><br>
<textarea name="script" rows="25" cols="<?php echo "$wide_textarea_chars"; ?>">
</textarea><br>
Comments:<br>
<textarea name="comment" rows="2" cols="<?php echo "$wide_textarea_chars"; ?>">
</textarea>
<br>
<?php
if (isset($_SESSION['chainscriptsubmit'])) $chainscriptsubmit = $_SESSION['chainscriptsubmit']; else $chainscriptsubmit = ""; 
echo "<input name=\"anothersubmit\" type=\"checkbox\" value=\"1\" ";
if ($chainscriptsubmit==1) echo "checked=\"checked\"";
echo " />Submit Another Script after this one<br>";
?>
<input type="Submit" value="Submit script">
</form>
<?php include("bottom.inc.php") ?> 
</body>
</html>
