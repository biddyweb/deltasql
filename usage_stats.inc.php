<?php

function get_usagestats_version() {
  // a connection needs to be established
  $query="SELECT * from tbparameter where paramtype='USAGESTATS' and paramname='VERSION'"; 
  $result=mysql_query($query);  
  $num=mysql_numrows($result); 

  if ($num>0) {
     $version=mysql_result($result,0,"paramvalue");
  } else {
      $version="0";
	  $query2="INSERT INTO tbparameter VALUES ('', 'USAGESTATS', 'VERSION', '$version');"; 
      mysql_query($query2);
  }
  return $version;
}

function set_usagestats_version($version) {
  // a connection needs to be established
  $query2="UPDATE tbparameter p SET p.paramvalue='$version' where paramtype='USAGESTATS' and paramname='VERSION'"; 
  mysql_query($query2);
  return $version;
}

function count_records($table) {
  $querycount = "SELECT count(*) from $table;";
  $resultcount=mysql_query($querycount);
  if ($resultcount!="") {
    $nbrecords=mysql_result($resultcount,0,'count(*)');
  } else $nbrecords=0;
  
  return $nbrecords;
}

function store_stats() {
  // a connection needs to be established
  include("utils/constants.inc.php");
  // collect data for the phone call
  $nbscripts  = count_records("tbscript");
  $nbmodules  = count_records("tbmodule");
  $nbprojects = count_records("tbproject");
  $nbbranches = count_records("tbbranch");
  $nbsyncs    = count_records("tbusagehistory");
  $nbusers    = count_records("tbuser");
  $nbmp       = count_records("tbmoduleproject");
  $nbsb       = count_records("tbscriptbranch");

  answer_phone('localhost', $nbscripts, $nbmodules, $nbprojects, $nbbranches, $nbsyncs, $nbusers, $nbmp, $nbsb, $deltasql_version);  
}

function phone_home() {
  // a connection needs to be established
  include("utils/constants.inc.php");
  // collect data for the phone call
  $nbscripts  = count_records("tbscript");
  $nbmodules  = count_records("tbmodule");
  $nbprojects = count_records("tbproject");
  $nbbranches = count_records("tbbranch");
  $nbsyncs    = count_records("tbusagehistory");
  $nbusers    = count_records("tbuser");
  $nbmp       = count_records("tbmoduleproject");
  $nbsb       = count_records("tbscriptbranch");
  
  $timeout = 6;
  $old = ini_set('default_socket_timeout', $timeout);
  $handle = fopen("http://www.deltasql.org/deltasql/phone_call.php?nbscripts=$nbscripts&nbmodules=$nbmodules&nbprojects=$nbprojects&nbbranches=$nbbranches&nbsyncs=$nbsyncs&nbusers=$nbusers&nbmp=$nbmp&nbsb=$nbsb&version=$deltasql_version", 'r');
  ini_set('default_socket_timeout', $old);
  stream_set_timeout($handle, $timeout);
  stream_set_blocking($handle, 0); 

  fclose($handle);

  //die("<b>$nbscripts $nbmodules $nbprojects $nbbranches $nbsyncs $nbusers $nbmp $nbsb $deltasql_version</b>");
}

function answer_phone($ip, $nbscripts, $nbmodules, $nbprojects, $nbbranches, $nbsyncs, $nbusers, $nbmp, $nbsb, $deltasql_version) {
  // a connection needs to be established
   $query="INSERT INTO tbphonetranscript (id, ip, deltasql_version, create_dt, nbscripts, nbmodules, nbprojects, nbbranches, nbsyncs, nbusers, nbmp, nbsb ) VALUES ('', '$ip', '$deltasql_version', NOW(), $nbscripts, $nbmodules, $nbprojects, $nbbranches, $nbsyncs, $nbusers, $nbmp, $nbsb);"; 
   mysql_query($query);
}

?>