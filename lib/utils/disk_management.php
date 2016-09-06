<?php

namespace FroalaEditor\Utils;

require_once 'utils.php';

class DiskManagement {
  
  /**
  *
  * @param options
  *   (
  *     validation => array OR function
  *     resize: => array [only for images]
  *   )
  * @return {link: 'linkPath'} or error string
  */
  public static function upload($fileRoute, $options) {

    if (
      isset($options['validation']) &&
      !Utils::handleValidation($options['validation'])
    ) {
      return 'File does not meet the validation.';
    }

    // Get filename.
    $temp = explode(".", $_FILES["file"]["name"]);

    // Get extension.
    $extension = end($temp);

    // Generate new random name.
    $name = sha1(microtime()) . "." . $extension;

    $fullNamePath = $_SERVER['DOCUMENT_ROOT'] . $fileRoute . $name;

    $mimeType = Utils::getMimeType($_FILES["file"]["tmp_name"]);

    if (isset($options['resize']) && $mimeType != 'image/svg+xml') {
      // Resize image.
      $resize = $options['resize'];

      // Parse the resize params.
      $columns = $resize['columns'];
      $rows = $resize['rows'];
      $filter = isset($resize['filter']) ? $resize['filter'] : \Imagick::FILTER_UNDEFINED;
      $blur = isset($resize['blur']) ? $resize['blur'] : 1;
      $bestfit = isset($resize['bestfit']) ? $resize['bestfit'] : false;

      $imagick = new \Imagick($_FILES["file"]["tmp_name"]);

      $imagick->resizeImage($columns, $rows, $filter, $blur, $bestfit);
      $imagick->writeImage($fullNamePath);
      $imagick->destroy();
    } else {
      // Save file in the uploads folder.
      move_uploaded_file($_FILES["file"]["tmp_name"], $fullNamePath);
    }

    // Generate response.
    $response = new \StdClass;
    $response->link = $fileRoute . $name;

    return $response;
  }


  /**
  * Delete image from disk.
  *
  * @param src string
  * @return boolean
  */
  public static function delete($src) {

    $filePath = $_SERVER['DOCUMENT_ROOT'] . $src;
    // Check if file exists.
    if (file_exists($filePath)) {
      // Delete file.
      return unlink($filePath);
    }

    return true;
  }
}

class_alias('FroalaEditor\Utils\DiskManagement', 'FroalaEditor_DiskManagement');
?>