<?php
declare(strict_types=1);

require 'vendor/autoload.php';

error_reporting(E_ALL);
set_error_handler('App\FileException::errorHandler');			
set_exception_handler('App\FileException::exceptionHandler');	
