<?php

include_once( 'utils/openflashchart/open-flash-chart.php' );
include("conf/config.inc.php");

 // preparing data for chart
 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 $query="SELECT update_user, count(*) FROM tbsyncstats group by update_user order by count(*) desc;";
 $result=mysql_query($query);
 
 if ($result=="") {
    mysql_close();
    exit();
 } else {
  $num=mysql_numrows($result); 
 }
 
 $data = array();
 $labels = array();
 $i=0;
 while ($i<$num) { 
   $username=mysql_result($result,$i,"update_user");
   $count=mysql_result($result,$i,"count(*)");          
   
   $data[$i] = $username;
   $labels[$i] = $count;
   
   $i++;
 }
 mysql_close();
 


// use the chart class to build the chart:
$g = new graph();
$g->title( 'Top Ten Synchronizers', '{font-size:18px; color: #d01f3c}' );

//
// PIE chart, 60% alpha
//
$g->pie(60,'#505050','{font-size: 12px; color: #404040;');
//
// pass in two arrays, one of data, the other data labels
//
$g->pie_values( $labels, $data);
//
// Colours for each slice, in this case some of the colours
// will be re-used (3 colurs for 5 slices means the last two
// slices will have colours colour[0] and colour[1]):
//
$g->pie_slice_colours( array('#d01f3c','#356aa0','#C79810') );

$g->set_tool_tip( '#val#' );


// display the data
echo $g->render();
?>