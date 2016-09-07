<?php

require '../lib/froala_editor.php';
$options = array(
  'fieldname' => 'myImage',
  'validation' => function($filePath, $mimetype) {

    $imagick = new \Imagick($filePath);
    $size = $imagick->getImageGeometry();
    $imagick->destroy();

    if ($size['width'] != $size['height']) {
      return false;
    }

    return true;
  }
);
$response = FroalaEditor_Image::upload('/examples/uploads/', $options);

if (is_string($response)) {
  echo $response;
  http_response_code(404);
  return;
}

echo stripslashes(json_encode($response));
?>