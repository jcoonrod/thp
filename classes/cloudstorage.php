<?php 
require $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';
Class CloudStorage {
	use Google\Cloud\Storage\StorageClient; 
	$client = new StorageClient(['projectId' => 'thpmne']);
	$client->registerStreamWrapper();
	public function show($fullpath){
	};
	public function upload($sourcepath,$destpath){
	};
	public function download($fullpath){
		$ext=strtolower(substr($fullpath,strrpos($fullpath,'.')));
		$ct='binary/octet-stream'; // default for unknown type (downloads)
		$mode='attachment';
		$name=basename($fullpath);
		// Figure out the content type, as uploads set this incorrectly
		$cts=array("pdf"=>"application/pdf","jpeg"=>"image/jpeg",".jpg"=>"image/jpg");
		$cts["xlsx"]="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
		$cts["docx"]="application/vnd.openxmlformats-officedocument.wordprocessingml.document";
		$cts["pptx"]="application/vnd.openxmlformats-officedocument.presentationml.presentation";
		$cts["doc"]="application/msword";
		if(array_key_exists($ext,$cts)){ $ct=$cts[$ext]; $mode='inline'; }
		header("Content-Type:".$ct);
		header("Content-Disposition:$mode; filename=$name");
		echo readfile($path);
	}
}
