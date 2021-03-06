<?php
/*
This file is included both from dbsync_update.php called by the form dbsync.php and also from
 dbsync_automated_update.php, which is the file touched by deltasql clients.
 
 The core logic of deltasql is here.

*/
include("dbsync_currentversion.inc.php");
include("utils/verification_scripts.inc.php");
include("utils/zip.inc.php");
include("utils/syncutils.inc.php");
include("utils/timing.inc.php");

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
                          $exclbranch, $xmlformatted, $htmlformatted) {
				  
    
	 if (($tobranchid=='') || ($tobranchid==0)) {
	   removeSyncPath($sessionid);
	   mysql_close();
       errormessage(13, "-- There is no path between target branch and source branch, please check them", $xmlformatted, $htmlformatted);
	 }
	 
	 if ($frombranchid==$tobranchid) {
        $syncstr = "INSERT INTO tbscriptgeneration (sessionid,fromversionnr,toversionnr,frombranch,tobranch,frombranch_id,tobranch_id,exclbranch,create_dt)
	                VALUES ('$sessionid',$fromversionnr, $toversionnr,'$frombranchname','$tobranchname',$frombranchid,$tobranchid,$exclbranch,NOW());";
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
        	
		$syncstr = "INSERT INTO tbscriptgeneration (sessionid,fromversionnr,toversionnr,frombranch,tobranch,frombranch_id,tobranch_id,exclbranch,create_dt)
	                VALUES ('$sessionid',$sourceversionnr, $toversionnr,'$sourcebranchname','$tobranchname',$sourcebranchid,$tobranchid,$exclbranch,NOW());";
        mysql_query($syncstr);
		
		generateSyncPath($sessionid, $frombranchid, $fromversionnr, $frombranchname, $sourcebranchid, $sourceversionnr, $sourcebranchname,
		                 $exclbranch, $xmlformatted, $htmlformatted);
     }	 
}

function dbsyncupdate($projectid, $lastversionnr, $frombranchid, $tobranchid, $htmlformatted,
         $excludeviews, $excludepackages, $updateuser, $updatetype, $commitcomment, $schemaname, $dbtype,
         $xmlformatted, $singlefiles, $debug) {

include("conf/config.inc.php");	 
include('utils/constants.inc.php');

$startwatch = start_watch();
if (!isset($default_copypaste)) $default_copypaste=1;		 
$generated_scripts=0; // this variable keeps track of how many scripts are outputted

if ($projectid=="")  errormessage(10, "Not possible to compute a dbsync update if project name is missing.", $xmlformatted, $htmlformatted);

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

// retrieve $dbtype from database, $dbtype is specified from the interface only in deltasql server < 1.7.0. 
// With 1.7.0 we retrieve it from table tbproject
$useclause="";
if ($dbtype=="") {
    $queryprj="SELECT * from tbproject where id=$projectid"; 
    $resultprj=mysql_query($queryprj);   
	$dbtype=mysql_result($resultprj,0,"dbtype");
	// we retrieve also the USE clause for Microsoft SQL server
	$useclause=mysql_result($resultprj,0,"useclause");
}
if ($dbtype=="") errormessage(18, "Database type not specified!", $xmlformatted, $htmlformatted);

$headid=retrieve_head_id();

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
   // if it is a tag, lastversionnr is not needed!
   if ($lastversionnr!="") {
      mysql_close();
      errormessage(16, "Version number not allowed if synchronizing from a tag", $xmlformatted, $htmlformatted);
   }
   if (($fromprojectid!="") && ($fromprojectid!=$projectid)) {
	   mysql_close();
       errormessage(17, "-- The tag $frombranchname does not belong to the project!", $xmlformatted, $htmlformatted);
  }
  $lastversionnr=$fromversionnr;
  $frombranchid=$fromsourcebranchid;
  $frombranchname=$fromsourcebranch;	
   
} else {
  // lastversionnr is needed, if it is a branch or HEAD!
  if ($lastversionnr=="") {
          mysql_close();  
          errormessage(9, "Not possible to compute a dbsync update if version number is missing.", $xmlformatted, $htmlformatted);
  }
  if (($lastversionnr<0) || (!is_numeric($lastversionnr))) { 
     mysql_close();
	 errormessage(12, "Version number has to be greater equal zero.", $xmlformatted, $htmlformatted);
  }	 
}
if (($frombranchid<>$headid) && ($lastversionnr<$fromversionnr)) {
   mysql_close();
   errormessage(15, "-- The given version number is lower than when the branch was created.", $xmlformatted, $htmlformatted);
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
	if (($toprojectid!="") && ($toprojectid!=$projectid)) {
	   mysql_close();
       errormessage(17, "-- The tag $tagname does not belong to the project!", $xmlformatted, $htmlformatted);
	} 
} else $tagname="";


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
 }	
} 
// THE VERIFICATION PART ENDS HERE
// the output of the script begins, if all tests are passed

// generating sessionid
$c = uniqid (rand (),true);
$sessionid = md5($c);
// generating synchronization path
if ($upgradefromprodtodev==0) {
  generateSyncPath($sessionid, $frombranchid, $lastversionnr, $frombranchname, $tobranchid,  $toversionnr, $tobranchname, 0, $xmlformatted, $htmlformatted);
} else {
  $syncstr = "INSERT INTO tbscriptgeneration (sessionid,fromversionnr,toversionnr,frombranch,tobranch,frombranch_id,tobranch_id,exclbranch,create_dt)
	          VALUES ('$sessionid',$lastversionnr, $toversionnr,'HEAD','HEAD',$headid,$headid,0,NOW());";
  mysql_query($syncstr);
  generateSyncPath($sessionid, $headid, 0, 'HEAD', $frombranchid,  $lastversionnr, $frombranchname, 1, $xmlformatted, $htmlformatted);
}


if ($singlefiles==0) {
   
   if ($xmlformatted) {
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<xml>\n";
    echo "  <type>synchronization</type>\n";
    echo "  <maincomment>$commitcomment</maincomment>\n";
   } else {
	    // HTML and text formatted
	   if ($htmlformatted==1) {
			printCopyPasteLink("Copy to clipboard", 0, $default_copypaste);
			echo "<hr><br>";
		}	
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
   
   
   $textresult = printVerificationScript($dbtype, $htmlformatted, $projectname, $lastversionnr, $frombranchname, $xmlformatted, $useclause);
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
$numsg=mysql_numrows($resultsg);

if ($debug==1) {
	echo "<pre><i>\n-- DEBUG: TBSCRIPTGENERATION table\n";
	
	$i=0;
    while ($i<$numsg) {  
       $tbsgfromversionnr   = mysql_result($resultsg,$i,"fromversionnr");
	   $tbsgtoversionnr     = mysql_result($resultsg,$i,"toversionnr");
       $tbsgtobranchname    = mysql_result($resultsg,$i,"tobranch");
	   $tbsgexclbranch      = mysql_result($resultsg,$i,"exclbranch");
 
       echo "-- Branch: $tbsgtobranchname From: $tbsgfromversionnr To: $tbsgtoversionnr Excl. branch: $tbsgexclbranch\n";
       $i++;
    }
	echo "</i></pre>\n";
}

$i=0;

while ($i<$numsg) {  

     $tbsgfromversionnr = mysql_result($resultsg,$i,"fromversionnr");
	 $tbsgtoversionnr   = mysql_result($resultsg,$i,"toversionnr");
     $tbsgtobranchid    = mysql_result($resultsg,$i,"tobranch_id");
	 $tbsgexclbranch    = mysql_result($resultsg,$i,"exclbranch");
     $query="SELECT DISTINCT s.* from tbscript s, tbscriptbranch sb where (s.versionnr>$tbsgfromversionnr) and (s.versionnr<=$tbsgtoversionnr) and (s.module_id in (select module_id from tbmoduleproject where project_id=$projectid) and (s.id=sb.script_id) and ";
     if ($tbsgexclbranch==0) {
 	   $query="$query (sb.branch_id=$tbsgtobranchid))";
	 } else {
       $query="$query ($tbsgtobranchid NOT IN (select branch_id from tbscriptbranch WHERE script_id=s.id)) and ($headid IN (select branch_id from tbscriptbranch WHERE script_id=s.id)))";
     }	 
     if ($excludeviews==1) $query="$query  and (s.isaview=0)";
     if ($excludepackages==1) $query="$query  and (s.isapackage=0)";
     $query="$query  ORDER BY versionnr ASC";
	 
     if ($debug==1) echo "<p><pre><i>-- DEBUG: query to generate this update script was:\n-- $query\n</i></pre></p>";
     $result=mysql_query($query);   
     $generated_scripts+=output_scripts($result, $htmlformatted, $xmlformatted, $singlefiles, $textresult, $disable_sql_highlighting, $useclause, $dbtype);

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
	$schemastring = "";
	$usestring = "";
	if (($useclause!="") && ($dbtype==$db_sqlserver)) $usestring = "USE " . $useclause . ";\nGO\n";
	if ($dbtype==$db_sqlserver) $schemastring = "dbo.";
	$updatestring = $usestring . "INSERT INTO " . $schemastring . "tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)";
	$updatestring = "$updatestring\nVALUES ('$projectname', $toversionnr, '$tobranchname', '$tagname', '$updateuser', '$updatetype', $lastversionnr, '$frombranchname', '$dbtype');";
	if ($dbtype==$db_sqlserver) $updatestring=$updatestring . "\nGO\n";					
    
	if (!$xmlformatted) $updatestring = "$updatestring\n-- all scripts to reach db $tobranchname beginning from version $toversionnr on date $update_dt\n";
	
	$stopwatch = stop_watch_string($startwatch);
    $updatestring = "$updatestring-- synchronization script generated in $stopwatch seconds\n";
	     
    // query for the usage statistics
	$ip=$_SERVER['REMOTE_ADDR'];
	$usagestring = "INSERT INTO tbsyncstats (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE, UPDATE_DT, IP)
	                VALUES ('$projectname', $toversionnr, '$tobranchname', '$updateuser', '$updatetype', $lastversionnr, '$frombranchname', '$dbtype', NOW(), '$ip');";
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
	  
      include("bottom-with-navbar.inc.php");
	  
	  // paragraph for copy&paste functionality
	  printCopyPasteBlock("$textresult$commentstring\n$updatestring", $default_copypaste);
      
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
