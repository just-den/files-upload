<?php

// https://www.w3schools.com/php/php_file_upload.asp


session_start();

require 'bootstrap.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $args = [
        'permitted_extensions' => ['pdf', 'png', 'jpg', 'jpeg'],
        'upload_folder' => 'uploads', 
        // 'max_file_size' => 51200, // если надо изменить максим разрешённый объём файла в байтах
        'rename_duplicates' => true,
    ];

	// ДЛЯ ajax - HTTP_X_REQUESTED_WITH - устанавливается в заголовках
    if(
        isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && 
        $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
    ){
        $upload = new App\UploadWithAjax($args); 
        $result = $upload->upload();
        $messages = $upload->getMessages();
        if($result){
            echo json_encode($messages);
        }
	// ДЛЯ reload
    }else{
        $upload = new App\UploadWithReload($args); 
        $result = $upload->upload();
        $messages = $upload->getMessages();
        if($result){
            $_SESSION['upload_files'] = $messages;
            header('Location: index.php');
        }
    }
    
}

exit;