<?php

require '../lib/froala_editor.php';

$response = FroalaEditor\Image::doList('/examples/uploads/');

echo stripslashes(json_encode($response));

?>