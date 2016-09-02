<?php

require '../lib/froala_editor.php';

$options = array(
  'resize' => array(
    'columns' => 300,
    'rows' => 300,
    'bestfit' => true
  )
);
$response = FroalaEditor_Image::upload('/examples/uploads/', $options);

if (is_string($response)) {
  http_response_code(404);
  return;
}

echo stripslashes(json_encode($response));
?>