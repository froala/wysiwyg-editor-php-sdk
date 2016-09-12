<?php

require '../lib/froala_editor.php';

try {
  $response = FroalaEditor_Image::upload('/examples/uploads/');
  echo stripslashes(json_encode($response));
} catch (Exception $e) {
  echo $response;
  http_response_code(404);
}