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

    if (isset($options['resize'])) {
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
  *  @return boolean
  */
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


  /**
  * List images from disk
  *
  * @param folderPath string
  *
  * @return array of image properties
  *     - on success : [{url: 'url', thumb: 'thumb', name: 'name'}, ...]
  *     - on error   : {error: 'error message'}
  */
  public static function getList($folderPath) {

    // Array of image objects to return.
    $response = array();

    $absoluteFolderPath = $_SERVER['DOCUMENT_ROOT'] . $folderPath;

    // Image types.
    $image_types = Utils::$allowedImageMimeTypes;

    // Filenames in the uploads folder.
    $fnames = scandir($absoluteFolderPath);

    // Check if folder exists.
    if ($fnames) {
        // Go through all the filenames in the folder.
        foreach ($fnames as $name) {
            // Filename must not be a folder.
            if (!is_dir($name)) {
                // Check if file is an image.

                if (in_array(mime_content_type($absoluteFolderPath . $name), $image_types)) {
                    // Build the image.
                    $img = new \StdClass;
                    $img->url = $folderPath . $name;
                    $img->thumb = $folderPath . $name;
                    $img->name = $name;

                    // Add to the array of image.
                    array_push($response, $img);
                }
            }
        }
    }

    // Folder does not exist, respond with a JSON to throw error.
    else {
        $response = new StdClass;
        $response->error = "Images folder does not exist!";
    }

    return $response;
  }
}

?>