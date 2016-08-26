<?php

namespace FroalaEditor\Utils;

class Utils {

  public static function isFileValid($filename, $mimeType, $allowedExts, $allowedMimeTypes) {

    if (!$allowedExts || !$allowedMimeTypes) {
      return false;
    }

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

    if (is_array($validation)) {
      return Utils::isFileValid($filename, $mimeType, $validation['allowedExts'], $validation['allowedMimeTypes']);
    }

    // Else: no specific validating behaviour found.
    return false;
  }
}

?>



