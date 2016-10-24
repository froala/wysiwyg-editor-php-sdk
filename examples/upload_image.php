<?php

require __DIR__ . '/vendor/froala/wysiwyg-editor-php-sdk/lib/froala_editor.php';

try {
  $response = FroalaEditor_Image::upload('/examples/uploads/');
  echo stripslashes(json_encode($response));
} catch (Exception $e) {
  echo $response;
  http_response_code(404);
}