<?php session_start();

   include("utils/utils.inc.php");
   
   $filtertitle=$_POST['title'];
   $filtercomment=$_POST['comments'];
   $filterscript=$_POST['script'];
   
   $commentsmatchcase=$_POST['commentsmatchcase'];
   $scriptmatchcase=$_POST['scriptmatchcase'];
     
   $authorid=$_POST['authorid'];
   $moduleid=$_POST['moduleid'];
   $branchid=$_POST['branchid'];
   $frmisaview=$_POST['frmisaview'];
   $frmisapackage=$_POST['frmisapackage'];
   
   $fromversion=$_POST['fromversion'];
   $toversion=$_POST['toversion'];
   
   $fromdata=$_POST['fromdata'];
   $todata=$_POST['todata'];
   
   $textoutput=$_POST['frmtextlistoutput'];
   
   $modified=$_POST['frmmodified'];
   
   $scriptoffset = 0;
   $_SESSION["scriptoffset"] = $scriptoffset;
  
   $_SESSION["search_title"] = $filtertitle;
   $_SESSION["search_comments"] = $filtercomment;
   $_SESSION["search_script"] = $filterscript;
   
   $_SESSION["search_comments_matchcase"] = $commentsmatchcase;
   $_SESSION["search_script_matchcase"] = $scriptmatchcase;
     
   $_SESSION["search_authorid"] = $authorid;
   $_SESSION["search_moduleid"] = $moduleid;
   $_SESSION["search_branchid"] = $branchid;
   $_SESSION["search_frmisaview"] = $frmisaview;
   $_SESSION["search_frmisapackage"] = $frmisapackage;
   
   $_SESSION["search_fromversion"] = $fromversion;
   $_SESSION["search_toversion"] = $toversion;
   
   $_SESSION["search_fromdata"] = $fromdata;
   $_SESSION["search_todata"] = $todata;
   
   $_SESSION["search_modified"] = $modified;
   
   if ($textoutput==1) {
        js_redirect("list_scripts.php?textoutput=1&showall=1");
   } else {
        js_redirect("list_scripts.php");
   }   
?>