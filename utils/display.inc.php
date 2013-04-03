<?php
/*
	General GUI utils to display stuff
	
	(c) 2007-2013 HB9TVM and the deltasql team
*/

function color_row($date_now, $create_dt) {
// conversion from mySQL to a PHP date
preg_match ("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $create_dt, $regs);
$updated_php = mktime ($regs[4],$regs[5],$regs[6],$regs[2],$regs[3],$regs[1]);

$one_day=86400;
$one_hour=3600;
$one_minute=60;

$diff=($date_now-$updated_php);
if ($diff>(2*$one_day)) {
  echo "<tr>";
} else 
if ($diff>(5*$one_hour))
{  
  echo "<tr BGCOLOR=\"#99CCFF\">"; // blue
} else
if ($diff>(20*$one_minute)) {
  echo "<tr BGCOLOR=\"#FDD017\">"; //yellow 
} else {
  echo "<tr BGCOLOR=\"#33FF00\">"; //green
}
}
?>