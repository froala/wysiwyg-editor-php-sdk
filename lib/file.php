<?php

namespace FroalaEditor;

require_once 'utils/utils.php';
require_once 'utils/disk_management.php';

use FroalaEditor\Utils\Utils as Utils;
use FroalaEditor\Utils\DiskManagement as DiskManagement;

class File {

  public static $defaultUploadOptions = array(
    'allowedExts' => array('txt', 'pdf', 'doc'),
    'allowedMimeTypes' => array('text/plain', 'application/msword', 'application/x-pdf', 'application/pdf')
  );

  /**
  * File upload to disk.
  *
  * @param req request stream
  * @param options [optional]
  *   (
  *     fileRoute => string
  *     validation => string: 'file' OR function
  *   )
  *  @return {link: 'linkPath'} or error string
  */
  public static function upload($options = array()) {

    $options = array_merge(Utils::$defaultUploadOptions, File::$defaultUploadOptions, $options);
    return DiskManagement::upload($options);
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