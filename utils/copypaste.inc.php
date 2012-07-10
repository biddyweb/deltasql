<?php

function printCopyPasteJS() {
echo "
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
 echo "<p id='description'>";
 echo "$textblock";
 echo "</p>";
}
?>