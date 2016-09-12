<?php

require '../lib/froala_editor.php';
$options = array(
  'validation' => null
);

try {
  $response = FroalaEditor_File::upload('/examples/uploads/', $options);
  echo stripslashes(json_encode($response));
} catch (Exception $e) {
  echo $response;
  http_response_code(404);
}