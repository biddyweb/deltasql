<?

include_once( 'utils/openflashchart/open-flash-chart.php' );

// use the chart class to build the chart:
$g = new graph();
$g->title( 'Top Ten Submitters', '{font-size: 12px;}' );

$data = array();
$data[0] = 1;
$data[1] = 55;
$data[2] = 17;

$g->set_data( $data );
$g->set_y_max( 55) ;
$g->y_label_steps( 3 );

// display the data
echo $g->render();
?>