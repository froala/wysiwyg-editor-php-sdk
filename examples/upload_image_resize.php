<?php

require '../lib/froala_editor.php';

$response = FroalaEditor\Image::upload(array('fileRoute' => '/examples/uploads/', 'resize' => array('columns' => 50, 'rows' => 50)));

if (is_string($response)) {
  http_response_code(404);
  return;
}

echo stripslashes(json_encode($response));

?>