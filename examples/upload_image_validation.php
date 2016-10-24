<?php

require __DIR__ . '/vendor/froala/wysiwyg-editor-php-sdk/lib/froala_editor.php';

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

try {
  $response = FroalaEditor_Image::upload('/examples/uploads/', $options);
  echo stripslashes(json_encode($response));
} catch (Exception $e) {
  echo $response;
  http_response_code(404);
}