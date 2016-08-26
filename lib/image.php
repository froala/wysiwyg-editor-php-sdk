<?php

namespace FroalaEditor;

require_once 'utils/utils.php';
require_once 'utils/disk_management.php';

use FroalaEditor\Utils\Utils as Utils;
use FroalaEditor\Utils\DiskManagement as DiskManagement;

class Image {

  public static $defaultUploadOptions = array(
    'validation' => array(
      'allowedExts' => array('gif', 'jpeg', 'jpg', 'png', 'svg', 'blob'),
      'allowedMimeTypes' => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/svg+xml')
    ),
    'resize' => NULL
  );

  /**
  * Image upload to disk.
  *
  * @param fileRoute string
  * @param options [optional]
  *   (
  *     validation => array OR function
  *     resize: => array
  *   )
  *  @return {link: 'linkPath'} or error string
  */
  public static function upload($fileRoute, $options = NULL) {

    if (is_null($options)) {
      $options = Image::$defaultUploadOptions;
    } else {
      $options = array_merge(Image::$defaultUploadOptions, $options);
    }

    return DiskManagement::upload($fileRoute, $options);
  }

  /**
  * Delete image from disk.
  *
  *  @return boolean
  */
  public static function delete() {

    return DiskManagement::delete();
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

    return DiskManagement::getList($folderPath);
  }
}


?>