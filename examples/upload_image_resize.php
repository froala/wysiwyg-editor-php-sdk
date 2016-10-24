<?php

require __DIR__ . '/vendor/froala/wysiwyg-editor-php-sdk/lib/froala_editor.php';

$options = array(
  'resize' => array(
    'columns' => 300,
    'rows' => 300,
    'bestfit' => true
  )
);

try {
  $response = FroalaEditor_Image::upload('/examples/uploads/', $options);
  echo stripslashes(json_encode($response));
} catch (Exception $e) {
  echo $response;
  http_response_code(404);
}