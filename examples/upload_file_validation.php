<?php

require __DIR__ . '/vendor/froala/wysiwyg-editor-php-sdk/lib/froala_editor.php';

$options = array(
  'fieldname' => 'myFile',
  'validation' => function($filePath, $mimetype) {

    $size = filesize($filePath);

    if ($size > 10 * 1024 * 1024) {
      return false;
    }

    return true;
  }
);

try {
  $response = FroalaEditor_File::upload('/examples/uploads/', $options);
  echo stripslashes(json_encode($response));
} catch (Exception $e) {
  echo $response;
  http_response_code(404);
}