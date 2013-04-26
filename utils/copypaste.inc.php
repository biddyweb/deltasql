<?php

function isCopyPasteEnabled($default_copypaste) {
 if (!isset($default_copypaste)) $default_copypaste=1;
 if (!isset($_SESSION['copypaste'])) {
	$enabled = $default_copypaste;
 } else {
	$enabled = $_SESSION['copypaste'];
 }
 
 return $enabled;
}

function printCopyPasteJS($default_copypaste) {
if (isCopyPasteEnabled($default_copypaste)) echo "
<script type=\"text/javascript\" src=\"utils/zeroclipboard/ZeroClipboard.js\"></script>
";
}

function printCopyPasteBlock($textblock, $default_copypaste) {
  if (isCopyPasteEnabled($default_copypaste)) {
     /*
	 echo "
	 <script>
	function myFunction()
 {
 alert(\"Hello World!\");
 }
	
	function copy2Clip() {
		//var clip = new ZeroClipboard();
		clip.setText('test test test');
		alert('Copied!');
    }
	</script>
	";
    */
     
     echo "<font color='white'>";
     echo "<p id='clipboard_text'>";
     echo "$textblock";
     echo "</p>";
     echo "</font>";  
	 echo "<script type=\"text/javascript\" src=\"mainclipboard.js\"></script>";
   
    /*
    echo "
    <script>
	function copy2Clip() {
		var clip = new ZeroClipboard();
		clip.setText( \"$textblock\" );
    }
	</script>
    ";
	*/
    
  } 
}

function printCopyPasteLink($textlink, $separator, $default_copypaste) {
if (isCopyPasteEnabled($default_copypaste)) {
   echo "<a id=\"copy-button\" data-clipboard-target=\"clipboard_text\"><img src=\"icons/new.png\" /> Copy to Clipboard</a>";
   if ($separator) {
	  echo " | ";
   }
 }
}
?>