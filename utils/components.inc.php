<?php
/*
	Functions used to display recurring GUI components like Comboboxes or Checkboxes
	
	(c) 2007-2013 HB9TVM and the deltasql team
*/

function printProjectComboBox($defaultprojectid, $event="") {
 echo "<select NAME=\"frmprojectid\" $event>";
 $query="SELECT * FROM tbproject ORDER BY name";
 $result=mysql_query($query);
 $num=mysql_numrows($result); 
 
 $i=0;
 if ($defaultprojectid=="") echo "<option VALUE=\"\" SELECTED> ";
 while ($i<$num) { 
   $projectid=mysql_result($result,$i,"id");
   $projectname=mysql_result($result,$i,"name");
   echo "<option ";
   if ($projectid==$defaultprojectid) echo "SELECTED ";
   echo "VALUE=\"$projectid\">$projectname";
   $i++;
 }
 echo "</select>";
}


function printDatabaseComboBox ($mydefault) {
include("utils/constants.inc.php");                                                   
echo "<select name=\"frmdbtype\">";
if ($mydefault == "")  {
   echo "<option value=\"\" SELECTED> ";
} 
if ($mydefault == $db_oracle)
    echo "<option value=\"$db_oracle\" SELECTED>$db_oracle";
  else
    echo "<option value=\"$db_oracle\">$db_oracle";
if ($mydefault == $db_mysql)                                                   
    echo "<option value=\"$db_mysql\" SELECTED>$db_mysql";                    
  else                                                                          
    echo "<option value=\"$db_mysql\">$db_mysql";
if ($mydefault == $db_pgsql)                                                   
    echo "<option value=\"$db_pgsql\" SELECTED>$db_pgsql";                    
  else                                                                          
    echo "<option value=\"$db_pgsql\">$db_pgsql";
if ($mydefault == $db_sqlserver)        
   echo "<option value=\"$db_sqlserver\" SELECTED>$db_sqlserver";               
  else                                                                          
    echo "<option value=\"$db_sqlserver\">$db_sqlserver"; 
if ($mydefault == $db_sqlite)
    echo "<option value=\"$db_sqlite\" SELECTED>$db_sqlite";
  else
    echo "<option value=\"$db_sqlite\">$db_sqlite";	
if ($mydefault == $db_sybase)
    echo "<option value=\"$db_sybase\" SELECTED>$db_sybase";
  else
    echo "<option value=\"$db_sybase\">$db_sybase";
if ($mydefault == $db_other)
    echo "<option value=\"$db_other\" SELECTED>$db_other";
  else
    echo "<option value=\"$db_other\">$db_other";

echo "</select><br><br>";

}


function echo_files_as_select_options($basedir) {
 $dir_handle = @opendir("$basedir") or die("Unable to open $basedir");
 while ($file = readdir($dir_handle)) 
 {
   if (($file=="README.txt") || ($file=="CVS")) continue;
   if (($file!=".") && ($file!="..")) {
        echo "<option VALUE=\"$file\">$file";
   }  
 }
 closedir($dir_handle);
}

function printBranchesAndTags() {

 $headid=retrieve_head_id();
 $query="SELECT * FROM tbbranch where (id<>$headid) order by id ASC";
 $result=mysql_query($query);
 $num=mysql_numrows($result); 
 $i=0;
 
 echo "<option SELECTED VALUE=\"HEAD\">HEAD";
 while ($i<$num) { 
   $branchid=mysql_result($result,$i,"id");
   $branchname=mysql_result($result,$i,"name");
   echo "<option ";
   echo "VALUE=\"$branchname\">$branchname";
   $i++;
 }

}


?>