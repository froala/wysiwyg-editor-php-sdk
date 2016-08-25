<?php

namespace FroalaEditor\Utils;

require_once 'utils.php';

class DiskManagement {
  
  /**
  *
  * @param options
  *   (
  *     fileRoute => string
  *     validation => string: 'file', 'image'. OR function
  *   )
  * @return {link: 'linkPath'} or error string
  */
  public static function upload($options) {

    if (!Utils::handleValidation($options['validation'])) {
      return 'File does not meet the validation.';
    }

    // Get filename.
    $temp = explode(".", $_FILES["file"]["name"]);

    // Get extension.
    $extension = end($temp);

    // Generate new random name.
    $name = sha1(microtime()) . "." . $extension;

    // Save file in the uploads folder.
    move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $options['fileRoute'] . $name);

    // Generate response.
    $response = new \StdClass;
    $response->link = $options['fileRoute'] . $name;

    return $response;
  }

  public static function delete() {

    // Get src.
    $src = $_POST["src"];

    $filePath = $_SERVER['DOCUMENT_ROOT'] . $src;
    // Check if file exists.
    if (file_exists($filePath)) {
      // Delete file.
      return unlink($filePath);
    }

    return true;
  }

  public static function listt() {

  }
}

?>