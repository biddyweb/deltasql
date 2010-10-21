<?php

class createDirZip extends createZip {
 
	function get_files_from_folder($directory, $put_into) {
		if ($handle = opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
				if (is_file($directory.$file)) {
					$fileContents = file_get_contents($directory.$file);
					$this->addFile($fileContents, $put_into.$file);
				} elseif ($file != '.' and $file != '..' and is_dir($directory.$file)) {
					$this->addDirectory($put_into.$file.'/');
					$this->get_files_from_folder($directory.$file.'/', $put_into.$file.'/');
				}
			}
		}
		closedir($handle);
	}
}


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

function zip($source_path, $folder, $filename) {
  // TODO: does not work with MAC,
  // see http://www.web-development-blog.com/archives/tutorial-create-a-zip-file-from-folders-on-the-fly/
  $createZip = new createDirZip;
  $createZip->addDirectory('$folder/');
  $createZip->get_files_from_folder('$source_path/$folder/', '$folder/');

  $fileName = '$source_path/$filename';
  $fd = fopen ($fileName, 'wb');
  $out = fwrite ($fd, $createZip->getZippedfile());
  fclose ($fd);
 
  $createZip->forceDownload($fileName);
  @unlink($fileName);
}


?>