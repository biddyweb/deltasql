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
<script type=\"text/javascript\" src=\"ZeroClipboard.js\"></script>
";
}

function printCopyPasteBlock($textblock, $default_copypaste) {
  if (isCopyPasteEnabled($default_copypaste)) {
     echo "<font color='white'>";
     echo "<p id='clipboard_text'>";
     echo "$textblock";
     echo "</p>";
     echo "</font>";  
	 echo "<script type=\"text/javascript\" src=\"mainclipboard.js\"></script>";
  } 
}

function printCopyPasteLink($textlink, $separator, $default_copypaste) {
if (isCopyPasteEnabled($default_copypaste)) {
        echo "<a id=\"copy-button\" data-clipboard-target=\"clipboard_text\"><img src=\"icons/new.png\" /> Copy to Clipboard</a>";
        if ($separator) {
	      echo " | ";
        }
 } //if
}
?>