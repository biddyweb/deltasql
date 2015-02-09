<?php session_start();

   include("utils/utils.inc.php");
   
   $filtertitle=$_POST['title'];
   $filtercomment=$_POST['comments'];
   $filterscript=$_POST['script'];
    
   $authorid=$_POST['authorid'];
   $moduleid=$_POST['moduleid'];
   $branchid=$_POST['branchid'];
   if (!isset($_POST['frmisaview'])) $frmisaview=""; else $frmisaview=$_POST['frmisaview'];
   if (!isset($_POST['frmisapackage'])) $frmisapackage=""; else $frmisapackage=$_POST['frmisapackage'];
   
   $fromversion=$_POST['fromversion'];
   $toversion=$_POST['toversion'];
   
   $fromdata=$_POST['fromdata'];
   $todata=$_POST['todata'];
   
   $frmprojectid=$_POST['frmprojectid'];
   
   if (!isset($_POST['frmtextlistoutput'])) $textoutput=0; else $textoutput=$_POST['frmtextlistoutput'];
   
   if (!isset($_POST['frmmodified'])) $modified=0; else $modified=$_POST['frmmodified'];
   
   $scriptoffset = 0;
   $_SESSION["scriptoffset"] = $scriptoffset;
  
   $_SESSION["search_title"] = $filtertitle;
   $_SESSION["search_comments"] = $filtercomment;
   $_SESSION["search_script"] = $filterscript;
       
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
   
   $_SESSION["search_projectid"] = $frmprojectid;
     
   if ($textoutput==1) {
        js_redirect("list_scripts.php?textoutput=1&showall=1");
   } else {
        js_redirect("list_scripts.php");
   }    
?>