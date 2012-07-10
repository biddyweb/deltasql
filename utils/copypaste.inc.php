<?php

function isCopyPasteEnabled() {
 if (!isset($default_copypaste)) $default_copypaste=1;
 if (!isset($_SESSION['copypaste'])) {
	$enabled = $default_copypaste;
 } else {
	$enabled = $_SESSION['copypaste'];
 }
 
 return $enabled;
}

function printCopyPasteJS() {
if (isCopyPasteEnabled()) echo "
<script type=\"text/javascript\" src=\"utils/js/jquery-1.7.2.min.js\"></script>
<script type=\"text/javascript\" src=\"utils/js/jquery.zclip.min.js\"></script>
<script>
$(document).ready(function(){
    $('a#copy-description').zclip({
        path:'utils/js/ZeroClipboard.swf',
        copy:$('p#description').text()
    });
    $('a#copy-dynamic').zclip({
        path:'utils/js/ZeroClipboard.swf',
        copy:function(){return $('input#dynamic').val();}
    });
});
</script>
";
}

function printCopyPasteBlock($textblock) {
if (isCopyPasteEnabled()) {
 echo "<font color='white'>";
 echo "<p id='description'>";
 echo "$textblock";
 echo "</p>";
 echo "</font>";
} 
}

function printCopyPasteLink($textlink, $separator) {
if (isCopyPasteEnabled()) {
   echo "<img alt=\"Copy to clipboard\" src=\"icons/copy.png\"><a href=\"#\" id=\"copy-description\">$textlink</a>";
   if ($separator) {
	  echo " | ";
   }
 }
}
?>