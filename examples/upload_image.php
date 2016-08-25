<?php

require '../lib/froala_editor.php';

$response = FroalaEditor\Image::upload(array('fileRoute' => '/uploads/'));

if (is_string($response)) {
  http_response_code(404);
  return;
}

$response->link = '/examples' . $response->link;
echo stripslashes(json_encode($response));

?>