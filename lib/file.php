<?php

namespace FroalaEditor;

require_once 'utils/utils.php';
require_once 'utils/disk_management.php';

use FroalaEditor\Utils\Utils as Utils;
use FroalaEditor\Utils\DiskManagement as DiskManagement;

class File {

  public static $defaultUploadOptions = array(
    'validation' => array(
      'allowedExts' => array('txt', 'pdf', 'doc'),
      'allowedMimeTypes' => array('text/plain', 'application/msword', 'application/x-pdf', 'application/pdf')
    )
  );

  /**
  * File upload to disk.
  *
  * @param fileRoute string
  * @param options [optional]
  *   (
  *     validation => array OR function
  *   )
  *  @return {link: 'linkPath'} or error string
  */
  public static function upload($fileRoute, $options = NULL) {

    if (is_null($options)) {
      $options = File::$defaultUploadOptions;
    } else {
      $options = array_merge(File::$defaultUploadOptions, $options);
    }

    return DiskManagement::upload($fileRoute, $options);
  }

  /**
  * Delete file from disk.
  *
  *  @return boolean
  */
  public static function delete() {

    return DiskManagement::delete();
  }
}


    
?>