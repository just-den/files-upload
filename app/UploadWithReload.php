<?php

namespace App;

use App\Upload;

class UploadWithReload extends Upload
{
    public function upload()
	{	
        if(isset($_FILES['filename'])){
			$uploaded = current($_FILES);
			foreach ($uploaded['name'] as $key => $value) {
				$currentFile['name'] = $uploaded['name'][$key];
				$currentFile['type'] = $uploaded['type'][$key];
				$currentFile['tmp_name'] = $uploaded['tmp_name'][$key];
				$currentFile['error'] = $uploaded['error'][$key];
				$currentFile['size'] = $uploaded['size'][$key];
                if($this->checkFile($currentFile)){
					$this->moveFile($currentFile);
				}
            }
        }		
		return true;
	}
}