<?php
include_once ("utils/constants.inc.php");
if (file_exists($configurationfile)) include_once ("conf/config.inc.php");
if ($enterprise_edition==true) {?> 
    <center>
      <a href="index.php"><img src="<?echo($enterprise_logo);?>"alt="logo" border=0></a>
    </center>
<?} else { ?>
    <a href="index.php"><img src="pictures/deltasql.png" alt="logo" border=0></a>
<?}?>
