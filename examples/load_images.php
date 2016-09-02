<?php

require '../lib/froala_editor.php';

$response = FroalaEditor_Image::getList('/examples/uploads/');

echo stripslashes(json_encode($response));
?>