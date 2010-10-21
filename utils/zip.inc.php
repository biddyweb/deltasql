<?php

function unpack_zip($source_path, $target_dir) {
$dir = $target_dir;
$zip = zip_open($source_path);
while($zip_entry = zip_read($zip)) {
$entry = zip_entry_open($zip,$zip_entry);
$filename = zip_entry_name($zip_entry);
$target_dir = $dir.substr($filename,0,strrpos($filename,'/'));
$filesize = zip_entry_filesize($zip_entry);
if (is_dir($target_dir) || mkdir($target_dir)) {
    if ($filesize > 0) {
                $contents = zip_entry_read($zip_entry, $filesize);
                file_put_contents($dir.$filename,$contents);
            }
        }
    }
}

function zip($source_path, $folder, $zipName) {
  include("createzip/CreateZipFile.inc.php");

  $createZipFile=new CreateZipFile;
  $createZipFile->zipDirectory("$source_path/$folder",$source_path);
  $fd=fopen("$source_path/$zipName", "wb");
  $out=fwrite($fd,$createZipFile->getZippedfile());
  fclose($fd);
}
?>