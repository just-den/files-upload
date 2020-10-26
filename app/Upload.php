<?php

namespace App;

use App\FileException;

abstract class Upload
{
  public $messages = [
    'errors' => [],
    'success' => []
  ];
  protected $max_size = 51200; // 50 * 1024 - не может исп калькуляция
  protected $permitted_extensions = [];
  protected $new_name;
  // private $not_trusted = array('bin', 'cgi', 'exe', 'js', 'pl', 'php', 'py', 'sh');
  // private $suffix = '.upload';
  protected $rename_duplicates = false;
  protected $upload_folder = '/uploads'; // по умолчанию
  protected $max_file_uploads;


  public function __construct($args)
  {
    // ДИРЕКТОРИЯ
    if (!empty($args['upload_folder'])) {
      $this->upload_folder = $args['upload_folder'];
    }

    if (!is_dir($this->upload_folder)) {
      mkdir($this->upload_folder);
    }

    if (!is_writable($this->upload_folder)) {
      throw new FileException("$this->upload_folder must be a valid, writable folder.");
    }

    if ($this->upload_folder[strlen($this->upload_folder) - 1] != '/') {
      $this->upload_folder .= '/';
    }

    // РАСШИРЕНИЯ
    if (isset($args['permitted_extensions']) && is_array($args['permitted_extensions'])) {
      $this->permitted_extensions = $args['permitted_extensions'];
    }

    // МАКСИМ РАЗРЕШ РАЗМЕР ФАЙЛА
    if (isset($args['max_file_size'])) {
      $this->setMaxSize($args['max_file_size']);
    }

    // ПЕРЕИМЕНОВАНИЕ ДУБЛИКАТОВ
    if (isset($args['rename_duplicates']) && $args['rename_duplicates'] === true) {
      $this->rename_duplicates = $args['rename_duplicates'];
    }

    // МАКСИМ КОЛ-ВО ФАЙЛОВ
    $this->max_file_uploads = ini_get('max_file_uploads');
  }

  abstract public function upload();

  private function setMaxSize($bytes)
  {
    $serverMax = self::convertToBytes(ini_get('upload_max_filesize'));
    if ($bytes > $serverMax) {
      throw new FileException('Maximum size cannot exceed server limit for individual files: ' . self::convertFromBytes($serverMax));
    }

    if (is_numeric($bytes) && $bytes > 0) {
      $this->max_size = $bytes;
    }
  }

  public static function convertToBytes($val)
  {
    $val = trim($val);
    $last = strtolower($val[strlen($val) - 1]);
    preg_match('/\d+/', $val, $output_array);
    $val = $output_array[0];
    if (in_array($last, array('g', 'm', 'k'))) {

      switch ($last) {
        case 'g':
          $val *= 1024;
        case 'm':
          $val *= 1024;
        case 'k':
          $val *= 1024;
      }
    }

    return $val;
  }

  public static function convertFromBytes($bytes)
  {
    $bytes /= 1024;
    if ($bytes > 1024) {
      return number_format($bytes / 1024, 1) . ' MB';
    } else {
      return number_format($bytes, 1) . ' KB';
    }
  }

  protected function checkFile($file)
  {
    if ($file['error'] !== 0) {
      $this->setErrorMessage($file);
      return false;
    }
    if (!$this->checkSize($file)) {
      return false;
    }
    if (!$this->checkType($file)) {
      return false;
    }
    $this->checkName($file);
    return true;
  }

  private function checkSize($file)
  {
    if ($file['size'] == 0) {
      $this->messages['errors'][] = $file['name'] . ' is empty.';
      return false;
    } elseif ($file['size'] > $this->max_size) {
      $this->messages['errors'][] = $file['name'] . ' exceeds the maximum size for a file (' . self::convertFromBytes($this->max_size) . ').';
      return false;
    } else {
      return true;
    }
  }

  private function checkType($file)
  {
    if (count($this->permitted_extensions) > 0) {
      $target_file = $this->upload_folder . basename($file["name"]);
      $ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      if (in_array($ext, $this->permitted_extensions)) {
        return true;
      } else {
        $this->messages['errors'][] = $file['name'] . ' is not permitted type of file.';
        return false;
      }
    }
    return true;
  }

  protected function checkName($file)
  {
    $this->new_name = null;
    $nospaces = str_replace(' ', '_', $file['name']); // меняем пробелы на подчёрк
    if ($nospaces != $file['name']) {
      $this->new_name = $nospaces;  // задаём новое имя
    }
    /*             
             pathinfo - массив информации о загруженном файле ( имя, путь, расширение и т.д. )
		*/
    $nameparts = pathinfo($nospaces);
    $extension = isset($nameparts['extension']) ? $nameparts['extension'] : '';
    if ($this->rename_duplicates) {
      $name = isset($this->new_name) ? $this->new_name : $file['name'];
      $existing = scandir($this->upload_folder);
      if (in_array($name, $existing)) {
        $i = 1;
        do {
          $this->new_name = $nameparts['filename'] . '_' . $i++;
          if (!empty($extension)) {
            $this->new_name .= ".$extension";
          }
        } while (in_array($this->new_name, $existing));
      }
    }
  }

  protected function moveFile($file)
  {
    $filename = isset($this->new_name) ? $this->new_name : $file['name'];
    $success = move_uploaded_file($file['tmp_name'], $this->upload_folder . $filename);
    if ($success) {
      $result = $file['name'] . ' was uploaded successfully';
      if (!is_null($this->new_name)) {
        $result .= ', and was renamed ' . $this->new_name;
      }
      $result .= '.';
      $this->messages['success'][] = $result;
    } else {
      $this->messages['errors'][] = 'Could not upload ' . $file['name'];
    }
  }

  private function setErrorMessage($file)
  {
    switch ($file['error']) {
      case 1:
      case 2:
        $this->messages['errors'][] = $file['name'] . ' is too big: (max: ' .
          self::convertFromBytes($this->maxSize) . ').';
        break;
      case 3:
        $this->messages['errors'][] = $file['name'] . ' was only partially uploaded.';
        break;
      case 4:
        $this->messages['errors'][] = 'No file was uploaded.';
        break;
      case 6:
        $this->messages['errors'][] = 'Missing a temporary folder.';
        break;
      case 7:
        $this->messages['errors'][] = 'Failed to write file to disk.';
        break;
      case 8:
        $this->messages['errors'][] = 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.';
        break;
      default:
        $this->messages['errors'][] = 'Sorry, there was a problem uploading ' . $file['name'];
        break;
    }
  }

  public function getMessages()
  {
    return $this->messages;
  }
}
