<?php

namespace FroalaEditor\Utils;

class Utils {
  
  public static $defaultUploadOptions = array(
    'fileRoute'  => '/uploads/',
    'validation' => null
  );

  public static $allowedFileExts = array('txt', 'pdf', 'doc');
  public static $allowedImageExts = array('gif', 'jpeg', 'jpg', 'png', 'blob');

  public static $allowedFileMimeTypes = array('text/plain', 'application/msword', 'application/x-pdf', 'application/pdf');
  public static $allowedImageMimeTypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png');

  public static function isFileValid($filename, $mimeType, $allowedExts, $allowedMimeTypes) {

    // Get extension.
    $extension = end($filename);

    return in_array(strtolower($mimeType), $allowedMimeTypes) && in_array(strtolower($extension), $allowedExts);
  }

  public static function handleValidation($validation) {

    // No validation means you dont want to validate, so return affirmative.
    if (!$validation) {
      return true;
    }

    // Get filename.
    $filename = explode(".", $_FILES["file"]["name"]);

    // Validate uploaded files.
    // Do not use $_FILES["file"]["type"] as it can be easily forged.
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

    // Validation is a function provided by the user.
    if ($validation instanceof Closure) {
        return $validation($filename, $mimeType);
    }

    if ($validation == 'file') {
      return Utils::isFileValid($filename, $mimeType, Utils::$allowedFileExts, Utils::$allowedFileMimeTypes);
    }
    if ($validation == 'image') {
      return Utils::isFileValid($filename, $mimeType, Utils::$allowedImageExts, Utils::$allowedImageMimeTypes);
    }

    // Else: no specific validating behaviour found.
    return false;
  }
}

?>



