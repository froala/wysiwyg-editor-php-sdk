<?php

namespace FroalaEditor;

require_once 'utils/utils.php';
require_once 'utils/disk_management.php';

use FroalaEditor\Utils\Utils as Utils;
use FroalaEditor\Utils\DiskManagement as DiskManagement;

class File {

  /**
  File upload to disk.

  @param req request stream
  @param options [optional]
    (
      fileRoute => string
      validation => string: 'file', 'image'. OR function
    )
  @param callback
  */
  public static function upload($options = array()) {

    $options = array_merge(Utils::$defaultUploadOptions, array('validation' => 'file'), $options);
    $response = DiskManagement::upload($options);

    echo stripslashes(json_encode($response));
  }

  public static function delete() {

  }
}


    
?>