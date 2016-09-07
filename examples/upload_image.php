<?php

require '../lib/froala_editor.php';

$response = FroalaEditor_Image::upload('/examples/uploads/');

if (is_string($response)) {
  echo $response;
  http_response_code(404);
  return;
}

echo stripslashes(json_encode($response));
?>