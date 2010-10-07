<?php
/*
This file is included both from dbsync_update.php called by the form dbsync.php and also from
 dbsync_automated_update.php, which is the file touched by deltasql clients.
 
 The core logic of deltasql is here.

*/

include("dbsync_currentversion.inc.php");
include("utils/verification_scripts.inc.php");


function dbsyncupdate($projectid, $lastversionnr, $frombranchid, $tobranchid, $htmlformatted,
         $excludeviews, $excludepackages, $updateuser, $updatetype, $commitcomment, $schemaname, $dbtype,
         $xmlformatted) {

$debug=0; // 1 will print more verbose update scripts!
$generated_scripts=0; // this variable keeps track of how many scripts are outputted

if ($lastversionnr=="")  errormessage(9, "Not possible to compute a dbsync update if version number is missing.", $xmlformatted, $htmlformatted);
if (($lastversionnr<0) || (!is_numeric($lastversionnr)))  errormessage(12, "Version number has to be greater equal zero.", $xmlformatted, $htmlformatted);
if ($projectid=="")  errormessage(10, "Not possible to compute a dbsync update if project name is missing.", $xmlformatted, $htmlformatted);

include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query16 = "SELECT * from tbmoduleproject where project_id=$projectid";   
$result16=mysql_query($query16);
if ($result16!="") { $num16=mysql_numrows($result16); } else {$num16=0;}
if ($num16==0) {
   errormessage(11, "-- Project does not contain any modules. Please add at least one module to the project!", $xmlformatted, $htmlformatted);
}

// retrieve branch information
$query3="SELECT * from tbbranch where id=$frombranchid"; 
$result3=mysql_query($query3);   
$fromprojectid=mysql_result($result3,0,"project_id");
$fromversionnr=mysql_result($result3,0,"versionnr");
$frombranchname=mysql_result($result3,0,"name");

$query4="SELECT * from tbbranch where id=$tobranchid"; 
$result4=mysql_query($query4);   
$toprojectid=mysql_result($result4,0,"project_id");
$toversionnr=mysql_result($result4,0,"versionnr");
$tobranchname=mysql_result($result4,0,"name");

// retrieve project name
$query77="SELECT * from tbproject where id=$projectid"; 
$result77=mysql_query($query77);   
$projectname=mysql_result($result77,0,"name");

// verify that the branch tags are for this project
if (($fromprojectid!=$projectid) && ($frombranchname!="HEAD")) {
  errormessage(5, "The source branch $frombranchname does not belong to the project $projectname", $xmlformatted, $htmlformatted);
}
if (($toprojectid!=$projectid) && ($tobranchname!="HEAD")) {
  errormessage(6, "The target branch $tobranchname does not belong to the project $projectname", $xmlformatted, $htmlformatted);
}

/* adapt from and to version numbers*/
$addheadscriptstoupdatedbranch=0;
$addbranchscriptsafterbranch=0;
$includeheadid=-1;
if ($frombranchname=="HEAD") {
// the start is HEAD
           
   if ($tobranchname=="HEAD") {
     // the target is HEAD
     $fromversionnr=$lastversionnr;
   } else {
      // the target is a branch
      $addbranchscriptsafterbranch=1;
      $fromversionnr=$lastversionnr;
   }
   
} else {
   // the start is a branch
   if ($tobranchname!="HEAD") {
      // also the end is a branch
      $addbranchscriptsafterbranch=1;
   }
   
   if ($fromversionnr<$lastversionnr) {
     // not only a branch but an updated branch
     if ($tobranchname!="HEAD") {
        // it is a branch to branch update
        if ($frombranchid!=$tobranchid) {
            // the two branches are different, and the branch is an updated branch
            $addheadscriptstoupdatedbranch=1;
        } else {
          // the two branches are equal, we can do the normal query, just set:
          $fromversionnr=$lastversionnr;
        }
     } else {    
       // it is a special branch to head update
       $addheadscriptstoupdatedbranch=1;
       //includeheadid is implicit, as the target branch is head
     }  
   } else if ($fromversionnr==$lastversionnr) {
       // this is okay, it is not an updated branch
   } else {
        errormessage(4, "There has to be a mistake in TBSYNCHRONIZE as the last version is lower than the source branch ($lastversionnr<$fromversionnr)", $xmlformatted, $htmlformatted);
   }
}

// the two branches are equal, let's take the latest version for the toversion field
if ($frombranchid==$tobranchid) {
   $toversionnr=dbsynccurrentversion("", $projectid, 0);
} else {
    // the two branches are different, we need to include HEAD scripts
    $includeheadid=retrieve_head_id(); 
}
/* end of adaption */


if ($toversionnr<$fromversionnr) {
  if ($frombranchid!=$tobranchid) {
    errormessage(7, "Cannot downgrade a project! (from $frombranchname [$fromversionnr] to $tobranchname [$toversionnr])", $xmlformatted, $htmlformatted);
  } else {
    errormessage(8, "-- No scripts to be executed (from $frombranchname [$fromversionnr] to $tobranchname [$toversionnr])", $xmlformatted, $htmlformatted);
  }  
}

// here begins the output of the script, if all tests are passed
if ($xmlformatted) {
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<xml>\n";
    echo "  <type>synchronization</type>\n";
    echo "  <maincomment>$commitcomment</maincomment>\n";
} else
if ($commitcomment!="") {
    echo "-- Commit Comment: "; 
    if ($htmlformatted==1) echo "<b><br>/*<h2>";
    echo "$commitcomment\n\n";
    if ($htmlformatted==1) echo "</h2>*/</b><br>";
}


printVerificationScript($dbtype, $htmlformatted, $projectname, $lastversionnr, $frombranchname, $xmlformatted);

if ($addheadscriptstoupdatedbranch=="1")  {

    $headid=retrieve_head_id();
    $query9="SELECT DISTINCT s.* from tbscript s, tbscriptbranch sb where (s.versionnr>$fromversionnr) and 
            (s.versionnr<=$lastversionnr) and (s.module_id in (select module_id from tbmoduleproject where project_id=$projectid) and 
            (s.id=sb.script_id) and (sb.branch_id=$headid)) and not exists 
            (select sb2.id from tbscriptbranch sb2 WHERE (sb2.script_id=s.id) and (sb2.branch_id=$frombranchid))
            ";
    if ($excludeviews==1) $query9="$query9  and (s.isaview=0)";
	if ($excludepackages==1) $query9="$query9  and (s.isapackage=0)";
	
    if ($debug==1) {
		echo "<p>-- WARNING this is an updated branch, we need an additional query which puts HEAD scripts up \n";
		echo "-- to the updated from branch in it if the target is HEAD. Scripts which are HEAD and source branch\n";
        echo "-- are excluded.\n\n</p>";
        echo "<b>-- $query9</b><br>";
    }
	
    
	$query9="$query9  ORDER BY versionnr ASC";
    $result9=mysql_query($query9);   
    $generated_scripts+=output_scripts($result9, $htmlformatted, $xmlformatted);
    // now reset the fromversion to the branch
    $fromversionnr=$lastversionnr;
    
}

$query="SELECT DISTINCT s.* from tbscript s, tbscriptbranch sb where (s.versionnr>$fromversionnr) and (s.versionnr<=$toversionnr) and (s.module_id in (select module_id from tbmoduleproject where project_id=$projectid) and (s.id=sb.script_id) and (sb.branch_id in ($includeheadid, $frombranchid, $tobranchid)))";
if ($excludeviews==1) $query="$query  and (s.isaview=0)";
if ($excludepackages==1) $query="$query  and (s.isapackage=0)";
$query="$query  ORDER BY versionnr ASC";
	 
if ($debug==1) echo "<p>-- DEBUG: query to generate this update script was:\n-- $query\n</p>";
$result=mysql_query($query);   
$generated_scripts+=output_scripts($result, $htmlformatted, $xmlformatted);


if ($addbranchscriptsafterbranch==1) {
    
    // used for from HEAD to branch updates
    if ($frombranchname=="HEAD") $frombranchid=-1;
    
    $query88="SELECT DISTINCT s.* from tbscript s, tbscriptbranch sb where (s.versionnr>$toversionnr) and (s.module_id in (select module_id from tbmoduleproject where project_id=$projectid) and (s.id=sb.script_id) and (sb.branch_id in ($frombranchid, $tobranchid)))";
    if ($excludeviews==1) $query="$query88  and (s.isaview=0)";
    if ($excludepackages==1) $query="$query88  and (s.isapackage=0)";
    $query="$query88  ORDER BY versionnr ASC";
	 
    if ($debug==1) echo "<p>-- DEBUG: query to generate this update script was:\n-- $query88\n</p>";
    $result88=mysql_query($query88);   
    $generated_scripts+=output_scripts($result88, $htmlformatted, $xmlformatted);
    
    // update the versionnr for the final statement
    $toversionnr = get_global_version();
}

// construct final update statement
$query13="SELECT * FROM tbbranch where name='HEAD'";
$result13=mysql_query($query13);
$update_dt=mysql_result($result13,0,"create_dt");


if ($generated_scripts>0) {
	$commentstring = "-- updating synchronization information for the database schema";
	$updatestring = "INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, DESCRIPTION, UPDATE_FROMVERSION, UPDATE_FROMSOURCE)";
	$updatestring = "$updatestring\nVALUES ('$projectname', $toversionnr, '$tobranchname', '$updateuser', '$updatetype', '$commitcomment', $fromversionnr, '$frombranchname');";
	
	if ($dbtype!="")
		$updatestring = "$updatestring\nUPDATE tbsynchronize SET dbtype='$dbtype' WHERE versionnr=$toversionnr;";
	if ($schemaname!="")
		$updatestring = "$updatestring\nUPDATE tbsynchronize SET schemaname='$schemaname' WHERE versionnr=$toversionnr;";
	if (!$xmlformatted) $updatestring = "$updatestring\n-- all scripts to reach db $tobranchname beginning from version $toversionnr on date $update_dt\n\n";
         
    // query for the usage statistics
	$usagestring = "INSERT INTO tbusagehistory (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, DESCRIPTION, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, SCHEMANAME, DBTYPE, UPDATE_DT)
	                VALUES ('$projectname', $toversionnr, '$tobranchname', '$updateuser', '$updatetype', '$commitcomment', $fromversionnr, '$frombranchname', '$schemaname', '$dbtype', NOW());";
    mysql_query($usagestring);
    
} else {
	$commentstring = "-- It is not necessary to execute any SQL script\n";
	$commentstring = "$commentstring-- The database schema is already uptodate\n\n";
    $updatestring = "";
}

if ($xmlformatted==1) {
    printXmlScript($updatestring, $commentstring, "" /*module*/, "" /*versionnr*/, "synchronization", "" /*date*/);
    echo "</xml>\n";
} else
if ($htmlformatted==1) {
      //html encoding
 	  geshi_highlight("$commentstring\n$updatestring", 'sql');
      echo '<br/><br/>';
} else {
	  echo "$commentstring\n$updatestring\n\n\n";
}

mysql_close();
}
?>
