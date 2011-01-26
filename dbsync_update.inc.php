<?php
/*
This file is included both from dbsync_update.php called by the form dbsync.php and also from
 dbsync_automated_update.php, which is the file touched by deltasql clients.
 
 The core logic of deltasql is here.

*/

include("dbsync_currentversion.inc.php");
include("utils/verification_scripts.inc.php");
include("utils/zip.inc.php");


function removeSyncPath($sessionid) {
  	 $delstr = "DELETE FROM tbscriptgeneration WHERE sessionid='$sessionid'";
     mysql_query($delstr);
}

/*
 This routine traverses back the tree in tbbranch by recursive calls and while traversing back,
 it creates entries in tbscriptgeneration. Exit point for the routine is when $frombranchid
 is null or when we reached the target
*/
function generateSyncPath($sessionid, $frombranchid, $fromversionnr, $frombranchname, $tobranchid,  $toversionnr, $tobranchname,
                          $xmlformatted, $htmlformatted) {
     
	 if (($tobranchid=='') || ($tobranchid==0)) {
	   removeSyncPath($sessionid);
	   mysql_close();
       errormessage(13, "-- There is no path between target branch and source branch, please check them", $xmlformatted, $htmlformatted);
	 }
	 
	 if ($frombranchid==$tobranchid) {
        $syncstr = "INSERT INTO tbscriptgeneration (sessionid,fromversionnr,toversionnr,frombranch,tobranch,frombranch_id,tobranch_id,create_dt)
	                VALUES ('$sessionid',$fromversionnr, $toversionnr,'$frombranchname','$tobranchname',$frombranchid,$tobranchid, NOW());";
        mysql_query($syncstr);
   	    // we are done, we exit recursion
		return;
     } else {
        // where do we want to go today? :-)
		$nextstr = "select * from tbbranch where id=$tobranchid;";
        $result_next=mysql_query($nextstr);
		$sourcebranchname=mysql_result($result_next,0,"sourcebranch");
		$sourcebranchid=mysql_result($result_next,0,"sourcebranch_id");
		$sourceversionnr=mysql_result($result_next,0,"versionnr");
		
		if ($sourceversionnr<$fromversionnr) $sourceversionnr=$fromversionnr;
        	
		$syncstr = "INSERT INTO tbscriptgeneration (sessionid,fromversionnr,toversionnr,frombranch,tobranch,frombranch_id,tobranch_id,create_dt)
	                VALUES ('$sessionid',$sourceversionnr, $toversionnr,'$sourcebranchname','$tobranchname',$sourcebranchid,$tobranchid, NOW());";
        mysql_query($syncstr);
		
		generateSyncPath($sessionid, $frombranchid, $fromversionnr, $frombranchname, $sourcebranchid, $sourceversionnr, $sourcebranchname,
		                 $xmlformatted, $htmlformatted);
     }	 
}

function dbsyncupdate($projectid, $lastversionnr, $frombranchid, $tobranchid, $htmlformatted,
         $excludeviews, $excludepackages, $updateuser, $updatetype, $commitcomment, $schemaname, $dbtype,
         $xmlformatted, $singlefiles) {

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
   mysql_close();
   errormessage(11, "-- Project does not contain any modules. Please add at least one module to the project!", $xmlformatted, $htmlformatted);
}

// retrieve branch information
$query3="SELECT * from tbbranch where id=$frombranchid"; 
$result3=mysql_query($query3);   
$fromprojectid=mysql_result($result3,0,"project_id");
$fromversionnr=mysql_result($result3,0,"versionnr");
$frombranchname=mysql_result($result3,0,"name");
$fromsourcebranch=mysql_result($result3,0,"sourcebranch");
$fromsourcebranchid=mysql_result($result3,0,"sourcebranch_id");
$fromistag=mysql_result($result3,0,"istag");
if ($fromistag==1) {
   mysql_close();
   die("<b>Internal error in dbsync_update.inc.php, Tags in from field are not allowed'");
}

$query4="SELECT * from tbbranch where id=$tobranchid"; 
$result4=mysql_query($query4);   
$toprojectid=mysql_result($result4,0,"project_id");
$toversionnr=mysql_result($result4,0,"versionnr");
$tobranchname=mysql_result($result4,0,"name");
$tosourcebranch=mysql_result($result4,0,"sourcebranch");
$tosourcebranchid=mysql_result($result4,0,"sourcebranch_id");
$toistag=mysql_result($result4,0,"istag");
if ($toistag==1) {
    $tagname=$tobranchname;
    $tobranchname=$tosourcebranch;
	$tobranchid=$tosourcebranchid;
}


// retrieve project name
$query77="SELECT * from tbproject where id=$projectid"; 
$result77=mysql_query($query77);   
$projectname=mysql_result($result77,0,"name");


if (($fromprojectid!=$projectid) && ($frombranchname!="HEAD")) {
     mysql_close();
     errormessage(5, "The source branch $frombranchname does not belong to the project $projectname", $xmlformatted, $htmlformatted);
}
if (($toprojectid!=$projectid) && ($tobranchname!="HEAD")) {
     mysql_close();
     errormessage(6, "The target branch $tobranchname does not belong to the project $projectname", $xmlformatted, $htmlformatted);
}


// if it is a branch, we override the latest version with the global version
if ($toistag==0) {
  $toversionnr = get_global_version();
}

if ($toversionnr<$lastversionnr) {
    mysql_close();
    errormessage(8, "-- No scripts to be executed (from $frombranchname [$lastversionnr] to $tobranchname [$toversionnr])", $xmlformatted, $htmlformatted);  
}

$upgradefromprodtodev=0;
if ($tobranchname=="HEAD") {
 if ($frombranchid!=$tobranchid) {
	// this is an upgrade of a production schema to a development schema which requires particular attention
	$upgradefromprodtodev=1;
	$headid=retrieve_head_id();
 }	
} 
if ($upgradefromprodtodev==1) {
     mysql_close();
     errormessage(14, "-- Upgrades from production schemas to development schemas not supported yet", $xmlformatted,$htmlformatted);
}


// generating sessionid
$c = uniqid (rand (),true);
$sessionid = md5($c);
// generating synchronization path
generateSyncPath($sessionid, $frombranchid, $lastversionnr, $frombranchname, $tobranchid,  $toversionnr, $tobranchname, $xmlformatted, $htmlformatted);

// THE VERIFICATION PART ENDS HERE
// the output of the script begins, if all tests are passed
if ($singlefiles==0) {
   
   if ($xmlformatted) {
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<xml>\n";
    echo "  <type>synchronization</type>\n";
    echo "  <maincomment>$commitcomment</maincomment>\n";
   } else {
       // HTML formatted
	   if ($commitcomment!="") {
          echo "-- Commit Comment: "; 
          if ($htmlformatted==1) echo "<b><br>/*<h2>";
          echo "$commitcomment\n\n";
          if ($htmlformatted==1) echo "</h2>*/</b><br>";
       }
	   
	   if ($upgradefromprodtodev==1) {
          if ($htmlformatted==1) echo "<b>";
          echo "-- WARNING: this script updates your production schema to a development schema (back to HEAD)!!!\n";
	      if ($htmlformatted==1) echo "<br>";
	      echo "-- you should review this script manually, before executing it!!\n";
	      if ($htmlformatted==1) echo "</b><br>";
       }
   }
   
   
   printVerificationScript($dbtype, $htmlformatted, $projectname, $lastversionnr, $frombranchname, $xmlformatted);
} else {
   empty_directory("output/scripts");
}


// We output scripts here according to the TBSCRIPTGENERATION table, but we read the entries in reversed order :-)
// so that we traverse from root of the tree to the leaf
$querysg="SELECT * FROM tbscriptgeneration WHERE sessionid='$sessionid' ORDER BY id desc";
$resultsg=mysql_query($querysg);
if ($resultsg=="") {
   mysql_close();
   die("Severe internal error in synchronization step: tbscriptgeneration is empty"); 
}

$i=0;
$numsg=mysql_numrows($resultsg);
 while ($i<$numsg) {  

     $tbsgfromversionnr = mysql_result($resultsg,$i,"fromversionnr");
	 $tbsgtoversionnr   = mysql_result($resultsg,$i,"toversionnr");
     $tbsgtobranchid    = mysql_result($resultsg,$i,"tobranch_id");
     $query="SELECT DISTINCT s.* from tbscript s, tbscriptbranch sb where (s.versionnr>$tbsgfromversionnr) and (s.versionnr<=$tbsgtoversionnr) and (s.module_id in (select module_id from tbmoduleproject where project_id=$projectid) and (s.id=sb.script_id) and ";
     $query="$query (sb.branch_id=$tbsgtobranchid))";
     if ($excludeviews==1) $query="$query  and (s.isaview=0)";
     if ($excludepackages==1) $query="$query  and (s.isapackage=0)";
     $query="$query  ORDER BY versionnr ASC";
	 
     if ($debug==1) echo "<p>-- DEBUG: query to generate this update script was:\n-- $query\n</p>";
     $result=mysql_query($query);   
     $generated_scripts+=output_scripts($result, $htmlformatted, $xmlformatted, $singlefiles);

     $i++;	 
}

// We clean up the entries with our sessionid in tbscriptgeneration
removeSyncPath($sessionid);

if ($singlefiles=="0") {
  // construct final update statement
  $query13="SELECT * FROM tbbranch where name='HEAD'";
  $result13=mysql_query($query13);
  $update_dt=mysql_result($result13,0,"create_dt");

  if ($generated_scripts>0) {
	$commentstring = "-- updating synchronization information for the database schema";
	$updatestring = "INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, DESCRIPTION, UPDATE_FROMVERSION, UPDATE_FROMSOURCE)";
	$updatestring = "$updatestring\nVALUES ('$projectname', $toversionnr, '$tobranchname', '$updateuser', '$updatetype', '$commitcomment', $lastversionnr, '$frombranchname');";
	
	if ($toistag==1)
		$updatestring = "$updatestring\nUPDATE tbsynchronize SET tagname='$tagname' WHERE versionnr=$toversionnr;";
	if ($dbtype!="")
		$updatestring = "$updatestring\nUPDATE tbsynchronize SET dbtype='$dbtype' WHERE versionnr=$toversionnr;";
	if ($schemaname!="")
		$updatestring = "$updatestring\nUPDATE tbsynchronize SET schemaname='$schemaname' WHERE versionnr=$toversionnr;";
	if (!$xmlformatted) $updatestring = "$updatestring\n-- all scripts to reach db $tobranchname beginning from version $toversionnr on date $update_dt\n\n";
         
    // query for the usage statistics
	$usagestring = "INSERT INTO tbusagehistory (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, DESCRIPTION, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, SCHEMANAME, DBTYPE, UPDATE_DT)
	                VALUES ('$projectname', $toversionnr, '$tobranchname', '$updateuser', '$updatetype', '$commitcomment', $lastversionnr, '$frombranchname', '$schemaname', '$dbtype', NOW());";
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
} // $singlefiles clause 
else {
  //if (file_exists("output/scripts.zip")) unlink("output/scripts.zip");
  zip("output", "scripts", "scripts.zip");
  js_redirect("output/scripts.zip");
}
mysql_close();
}
?>
