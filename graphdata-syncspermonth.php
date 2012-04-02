<?

include_once( 'utils/openflashchart/open-flash-chart.php' );
include("conf/config.inc.php");

 // preparing data for chart
 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 $query="select count(*), concat(month(update_dt),'-',year(update_dt)) as my from tbsyncstats group by my order by update_dt asc;";
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
 $max=20;
 while ($i<$num) { 
   // my is for month-year
   $my=mysql_result($result,$i,"my");
   $count=mysql_result($result,$i,"count(*)");          
   
   $data[$i] = $count;
   $labels[$i] = $my;
   
   if ($count>$max) $max=$count;
   
   $i++;
 }
 mysql_close();
 


// use the chart class to build the chart:
$g = new graph();
$g->title( 'Synchronizations per month', '{font-size:18px; color: #d01f3c}' );

//
// pass in two arrays, one of data, the other data labels
//
$g->set_data($data);
$g->set_x_labels($labels);
$g->set_x_label_style( 10, '#9933CC', 0, 2 );
$g->set_y_max( $max );

$g->set_tool_tip( '#val#' );


// display the data
echo $g->render();
?>