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
<script type=\"text/javascript\" src=\"utils/zeroclipboard/ZeroClipboard.js\">var clip = new ZeroClipboard();</script>
";
}

function printCopyPasteBlock($textblock, $default_copypaste) {
  if (isCopyPasteEnabled($default_copypaste)) {
     /*
     echo "<font color='white'>";
     echo "<p id='clipboard_text'>";
     echo "$textblock";
     echo "</p>";
     echo "</font>";  
    */
    echo "
    <script>
    clip.setText( \"$textblock\" );
    </script>
    ";
    
  } 
}

function printCopyPasteLink($textlink, $separator, $default_copypaste) {
if (isCopyPasteEnabled($default_copypaste)) {
   echo "<button id=\"my-button\" data-clipboard-target=\"clipboard_text\">Copy to Clipboard</button>";
   if ($separator) {
	  echo " | ";
   }
 }
}
?>