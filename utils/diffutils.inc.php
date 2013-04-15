<?php
/*
	Help functions used in get_diffs_changelog.php to
	display differences between script revisions.
	
	(c) 2007-2013 HB9TVM and the deltasql team
*/

function starts_with($Haystack, $Needle){
    return strpos($Haystack, $Needle) === 0;
}

function print_block($block) {
	if (starts_with($block, "+")) {
      echo "<tr bgcolor=\"#33FF00\"><td><code>$block</code></td></tr>\n";
	} else
    if (starts_with($block, "-")) {
	  echo "<tr bgcolor=\"#FDD017\"><td><code>$block</code></td></tr>\n";		
	} else {
	  echo "<tr><td><code>$block</code></td></tr>\n";
	}
}


function color_diff($difftext) {
 $lines = explode( "\n", $difftext);
 echo "<table border='0'>\n";
 for ( $i = 0; $i < sizeof( $lines ); $i++ ) {
	print_block($lines[$i]);
 }  
 echo "</table>\n";
}

?>
