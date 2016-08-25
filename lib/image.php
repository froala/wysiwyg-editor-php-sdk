<?php

namespace FroalaEditor;

require_once 'utils/utils.php';
require_once 'utils/disk_management.php';

use FroalaEditor\Utils\Utils as Utils;
use FroalaEditor\Utils\DiskManagement as DiskManagement;

class Image {

  /**
  * File upload to disk.
  *
  * @param options [optional]
  *   (
  *     fileRoute => string
  *     validation => string: 'image'. OR function
  *   )
  *  @return {link: 'linkPath'} or error string
  */
  public static function upload($options = array()) {

    $options = array_merge(Utils::$defaultUploadOptions, $options);
    $response = DiskManagement::upload($options);

    return $response;
  }
}


?>