<?php

function starts_with($Haystack, $Needle){
    return strpos($Haystack, $Needle) === 0;
}

function print_block($block) {
	if (starts_with($block, "+")) {
      echo "<tr BGCOLOR=\"#33FF00\"><pre>$block</pre></tr>";
	} else
    if (starts_with($block, "-")) {
	  echo "<tr BGCOLOR=\"#FDD017\"><pre>$block</pre></tr>";		
	} else {
	  echo "<tr><pre>$block</pre></tr>";
	}
}

function color_diff($difftext) {
 $lines = explode( "\n", $difftext);
 echo "<table>\n";
 $oldstartchar="";
 $block="";
 for ( $i = 0; $i < sizeof( $lines ); $i++ ) {
	$line=$lines[$i];
	if (starts_with($lines[$i], "+")) {
	    if ($oldstartchar!="+") {
			print_block($block);
			$block="";
		}
		$block = "$block$line\n";
		$oldstartchar="+";
	} else {
	  if (starts_with($lines[$i], "-")) {
		if ($oldstartchar!="-") {
		   print_block($block);
 		   $block="";
		}
		
		$block = "$block$line\n";
		$oldstartchar="-";
	  }
	  else {
         if ($oldstartchar=="") {
			$block="$block$line\n";
			$oldstartchar="";
		} else {
          print_block($block);
		  $block="";
        }       	
	  }	
	}	
 }  
 print_block($block);
 echo "</table>\n";
}
?>