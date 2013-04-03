<?php
/*
	Timing utils to measure page generation performance
	
	(c) 2007-2013 HB9TVM and the deltasql team
*/


// routines to measure page performance
function start_watch() {
  $time = microtime(); 
  $time = explode(' ', $time);
  $time = $time[1] + $time[0];
  return $time;
}

function stop_watch_string($start) {
  $time = microtime();
  $time = explode(' ', $time);
  $time = $time[1] + $time[0];
  $finish = $time;
  $total_time = round(($finish - $start), 4);
  return $total_time;
}

function stop_watch($start) {
  $total_time = stop_watch_string($start);
  echo 'Page generated in '.$total_time.' seconds.';
}
?>