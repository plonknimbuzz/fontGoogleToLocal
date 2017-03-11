<?php
if(empty($_POST['url'])) exit;
	set_time_limit(120);
	require_once("fontGoogleToLocal.php");
	$Obj = new fontGoogleToLocal;
	$Obj->setForceReplace(true); //optional
	$Obj->setLink($_POST['url']);
	$Obj->getCss();
	$files = $Obj->getListFile();
	
	$zipFile = tempnam("tmp", "zip");
	if(create_zip($files, $zipFile, true))
	{
		header('Content-Type: application/zip');
		header('Content-Length: ' . filesize($zipFile));
		header('Content-Disposition: attachment; filename="font.zip"');
		readfile($zipFile);
		foreach( array_merge($files,array($zipFile)) as $list)
		{
			unlink($list);
		}
		unlink($zipFile);
	} 
	else die("zip creation failed");

/* 
creates a compressed zip file 
script from: https://davidwalsh.name/create-zip-php
*/
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$exp = explode("/",$file);
			$fileName = end($exp); 
			$zip->addFile($file,$fileName);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}

?>
