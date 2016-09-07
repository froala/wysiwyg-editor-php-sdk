<?php

require '../lib/froala_editor.php';
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
$response = FroalaEditor_File::upload('/examples/uploads/', $options);

if (is_string($response)) {
  echo $response;
  http_response_code(404);
  return;
}

echo stripslashes(json_encode($response));
?>