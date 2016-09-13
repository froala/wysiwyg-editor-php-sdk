<?php

require '../lib/froala_editor.php';

try {
  $response = FroalaEditor_File::delete($_POST['src']);
  echo stripslashes(json_encode('Success'));
} catch (Exception $e) {
  echo $e->getMessage();
  http_response_code(404);
}