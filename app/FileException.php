<?php

/*

    ИСКЛ И ОШИБКИ FileException СОЗДАЮТСЯ ТАМ, ГДЕ ЕСТЬ НЕПРЕДВИД ОШИБКИ ЛИБО ИСКЛ ДО ЗАГРУЗКИ ЛЮБЫХ ФАЙЛОВ ( НЕЧИТАЕМАЯ ПАПКА, ПУСТОЙ МАССИВ FILES ETC)

    ОСТАЛЬНЫЕ ОШИБКИ КИДАЮТСЯ В МАССИВ ОШИБОК $messages['errors']

*/

namespace App;

class FileException extends \Exception{

    public static function errorHandler($level, $message, $file, $line)				
    {				
        if (error_reporting() !== 0) {  // to keep the @ operator working				
            throw new \ErrorException($message, 0, $level, $file, $line);			
        }				
    }	
    
    public static function exceptionHandler($exception)											
    {											
   											
        // Code is 404 (not found) or 500 (general error)											
        $code = $exception->getCode();											
        if ($code != 404) {											
            $code = 500;											
        }											
        // Получает или устанавливает код ответа HTTP т.е. отсыдаем браузеру перехваченный код ошибки											
       http_response_code($code);	
        
        $mode = 'dev';
        // $mode = 'prod';
 											
        if ($mode === 'prod') {											
            echo "<h1>Fatal error</h1>";											
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";											
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
            										
        } else {	
            $log = 'logs/' . date('Y-m-d') . '.txt';											
            // в php ini переопределяем путь логирования ошибок											
            ini_set('error_log', $log);	
					
            $message = "Uncaught exception: '" . get_class($exception) . "'";
            $message .= " with message '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . " \n\n\n";

            // Отправляет сообщение об ошибке заданному обработчику ошибок											
            error_log($message);	

            // ДЛЯ ajax
            if(
                isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
                && 
                $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
            ){
                echo json_encode($exception->getMessage());
                exit;
            }

            
            $_SESSION['upload_files']['errors'][0] = $exception->getMessage();
            header('Location: index.php');
            exit;
											
        }											
    }	

}