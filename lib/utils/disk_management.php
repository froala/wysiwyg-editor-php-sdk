<?php

namespace FroalaEditor\Utils;

require_once 'utils.php';

class DiskManagement {
  
  /**
  @param options
    (
      fileRoute => string
      validation => string: 'file', 'image'. OR function
    )
  @return {link: 'linkPath'} or error string
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
    move_uploaded_file($_FILES["file"]["tmp_name"], getcwd() . $options['fileRoute'] . $name);

    // Generate response.
    $response = new \StdClass;
    $response->link = $options['fileRoute'] . $name;

    return $response;
  }

  public static function delete() {

  }

  public static function listt() {

  }
}

?>