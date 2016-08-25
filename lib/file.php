<?php

namespace FroalaEditor;

require_once 'utils/utils.php';
require_once 'utils/disk_management.php';

use FroalaEditor\Utils\Utils as Utils;
use FroalaEditor\Utils\DiskManagement as DiskManagement;

class File {

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

    $options = array_merge(Utils::$defaultUploadOptions, $options);
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