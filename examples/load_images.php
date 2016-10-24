<?php

require __DIR__ . '/vendor/froala/wysiwyg-editor-php-sdk/lib/froala_editor.php';

$response = FroalaEditor_Image::getList('/examples/uploads/');

echo stripslashes(json_encode($response));
?>