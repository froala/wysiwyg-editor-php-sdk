<?php

require '../lib/froala_editor.php';

try {
  $response = FroalaEditor_Image::delete($_POST['src']);
  echo stripslashes(json_encode('Success'));
} catch (Exception $e) {
  echo $response;
  http_response_code(404);
}