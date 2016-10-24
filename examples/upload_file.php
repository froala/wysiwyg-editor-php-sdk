<?php

require __DIR__ . '/vendor/autoload.php';

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