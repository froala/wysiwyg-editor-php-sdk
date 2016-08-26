<?php

require '../lib/froala_editor.php';

$response = FroalaEditor\Image::getList('/examples/uploads/');

echo stripslashes(json_encode($response));

?>