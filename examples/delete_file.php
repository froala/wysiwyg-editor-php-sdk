<?php

require '../lib/froala_editor.php';

$response = FroalaEditor_File::delete($_POST['src']);

if (!$response) {
  echo $response;
  http_response_code(404);
  return;
}

echo stripslashes(json_encode('Success'));
?>