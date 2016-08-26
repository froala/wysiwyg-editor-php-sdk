<?php

require '../lib/froala_editor.php';

$response = FroalaEditor\Image::upload('/examples/uploads/');

if (is_string($response)) {
  http_response_code(404);
  return;
}

echo stripslashes(json_encode($response));

?>