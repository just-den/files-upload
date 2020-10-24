<?php

namespace App;

use App\Upload;

class UploadWithAjax extends Upload
{
    public function upload()
	{	
		if(count($_FILES) === 0) throw new FileException('No files');

		foreach ($_FILES as $key => $currentFile) {
			if($this->checkFile($currentFile)){
				$this->moveFile($currentFile);
			}
		}
		return true;
	}
}