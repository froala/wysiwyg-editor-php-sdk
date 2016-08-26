<?php

require '../lib/froala_editor.php';

// Load Amazon S3 config from system environment variables.
$keyStart = getenv('AWS_KEY_START');
$acl = getenv('AWS_ACL');
$accessKeyId = getenv('AWS_ACCESS_KEY');
$secretKey = getenv('AWS_SECRET_ACCESS_KEY');


$bucketV2 = getenv('AWS_BUCKET_V2');
$regionV2 = getenv('AWS_REGION_V2');

$bucketV4 = getenv('AWS_BUCKET_V4');
$regionV4 = getenv('AWS_REGION_V4');



// Get hash for V2 signing method.
$configV2 = array(
  'timezone' => 'Europe/Bucharest',
  'bucket' => $bucketV2,
  'region' => $regionV2,
  'keyStart' => $keyStart,
  'acl' => $acl,
  'accessKey' => $accessKeyId,
  'secretKey' => $secretKey
);

$hashV2 = FroalaEditor\S3::getHashV2($configV2);

// Process hash on frontend.
$policyV2 = $hashV2->params->policy;
$signatureV2 = $hashV2->params->signature;


// Get hash for V4 signing method.
$configV4 = array(
  'timezone' => 'Europe/Bucharest',
  'bucket' => $bucketV4,
  'region' => $regionV4,
  'keyStart' => $keyStart,
  'acl' => $acl,
  'accessKey' => $accessKeyId,
  'secretKey' => $secretKey
);

// Do not process hash on frontend.
$hashV4 = FroalaEditor\S3::getHashV4($configV4);
$hashV4 = stripslashes(json_encode($hashV4));

?>

<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0"/>
  <script src="/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Include Font Awesome. -->
  <link href="/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

  <!-- Include Froala Editor styles -->
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/froala_editor.min.css" />
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/froala_style.min.css" />

  <!-- Include Froala Editor Plugins styles -->
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/char_counter.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/code_view.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/colors.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/emoticons.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/file.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/fullscreen.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/image_manager.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/image.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/line_breaker.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/table.css">
  <link rel="stylesheet" href="/bower_components/froala-wysiwyg-editor/css/plugins/video.css">

  <!-- Include Froala Editor -->
  <script src="/bower_components/froala-wysiwyg-editor/js/froala_editor.min.js"></script>

  <!-- Include Froala Editor Plugins -->
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/align.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/char_counter.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/code_beautifier.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/code_view.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/colors.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/emoticons.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/entities.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/file.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/font_family.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/font_size.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/fullscreen.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/image.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/image_manager.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/inline_style.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/line_breaker.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/link.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/lists.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_format.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_style.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/quote.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/save.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/table.min.js"></script>
  <script src="/bower_components/froala-wysiwyg-editor/js/plugins/video.min.js"></script>
  <!-- End Froala -->

  <link rel="stylesheet" href="./app.css">


</head>

<body>
  <div class="sample">
    <h2>Sample 1: Save to disk</h2>
    <form>
      <textarea id="edit" name="content"></textarea>
    </form>
  </div>
  <script>
    $(function() {
      $('#edit').froalaEditor({

        imageUploadURL: '/examples/upload_image.php',
        imageUploadParams: {
          id: 'my_editor'
        },

        fileUploadURL: '/examples/upload_file.php',
        fileUploadParams: {
          id: 'my_editor'
        },

        imageManagerLoadURL: '/examples/load_images.php',
        imageManagerDeleteURL: "/examples/delete_image.php",
        imageManagerDeleteMethod: "POST"
      })
      // Catch image removal from the editor.
      .on('froalaEditor.image.removed', function (e, editor, $img) {
        $.ajax({
          // Request method.
          method: "POST",

          // Request URL.
          url: "/examples/delete_image.php",

          // Request params.
          data: {
            src: $img.attr('src')
          }
        })
        .done (function (data) {
          console.log ('image was deleted');
        })
        .fail (function (err) {
          console.log ('image delete problem: ' + JSON.stringify(err));
        })
      })

      // Catch image removal from the editor.
      .on('froalaEditor.file.unlink', function (e, editor, link) {

        $.ajax({
          // Request method.
          method: "POST",

          // Request URL.
          url: "/examples/delete_file.php",

          // Request params.
          data: {
            src: link.getAttribute('href')
          }
        })
        .done (function (data) {
          console.log ('file was deleted');
        })
        .fail (function (err) {
          console.log ('file delete problem: ' + JSON.stringify(err));
        })
      })
    });
  </script>

  <div class="sample">
    <h2>Sample 2: Save to disk (resize on server)</h2>
    <form>
      <textarea id="edit-resize" name="content"></textarea>
    </form>
  </div>
  <script>
    $(function() {
      $('#edit-resize').froalaEditor({

        imageUploadURL: '/examples/upload_image_resize.php',
        imageUploadParams: {
          id: 'my_editor'
        },

        fileUploadURL: '/examples/upload_file.php',
        fileUploadParams: {
          id: 'my_editor'
        },

        imageManagerLoadURL: '/examples/load_images.php',
        imageManagerDeleteURL: "/examples/delete_image.php",
        imageManagerDeleteMethod: "POST"
      })
      // Catch image removal from the editor.
      .on('froalaEditor.image.removed', function (e, editor, $img) {
        $.ajax({
          // Request method.
          method: "POST",

          // Request URL.
          url: "/examples/delete_image.php",

          // Request params.
          data: {
            src: $img.attr('src')
          }
        })
        .done (function (data) {
          console.log ('image was deleted');
        })
        .fail (function (err) {
          console.log ('image delete problem: ' + JSON.stringify(err));
        })
      })

      // Catch image removal from the editor.
      .on('froalaEditor.file.unlink', function (e, editor, link) {

        $.ajax({
          // Request method.
          method: "POST",

          // Request URL.
          url: "/examples/delete_file.php",

          // Request params.
          data: {
            src: link.getAttribute('href')
          }
        })
        .done (function (data) {
          console.log ('file was deleted');
        })
        .fail (function (err) {
          console.log ('file delete problem: ' + JSON.stringify(err));
        })
      })
    });
  </script>

  <div class="sample">
    <h2>Sample 3: Save to Amazon using signature version 2</h2>
    <form>
      <textarea id="edit-amazon-v2" name="content"></textarea>
    </form>
  </div>

  <script>
    $(function() {

      $('#edit-amazon-v2').froalaEditor({
        imageUploadToS3: {
          bucket: '<?php echo $bucketV2; ?>',
          region: '<?php echo $regionV2; ?>',
          keyStart: '<?php echo $keyStart; ?>',
          params: {
            acl: '<?php echo $acl; ?>',
            AWSAccessKeyId: '<?php echo $accessKeyId; ?>',
            policy: '<?php echo $policyV2; ?>',
            signature: '<?php echo $signatureV2; ?>',
          }
        },
        fileUploadToS3: {
          bucket: '<?php echo $bucketV2; ?>',
          region: '<?php echo $regionV2; ?>',
          keyStart: '<?php echo $keyStart; ?>',
          params: {
            acl: '<?php echo $acl; ?>',
            AWSAccessKeyId: '<?php echo $accessKeyId; ?>',
            policy: '<?php echo $policyV2; ?>',
            signature: '<?php echo $signatureV2; ?>',
          }
        }
      });

    });
  </script>

  <div class="sample">
    <h2>Sample 4: Save to Amazon using signature version 4</h2>
    <form>
      <textarea id="edit-amazon-v4" name="content"></textarea>
    </form>
  </div>

  <script>
    $(function() {
        $('#edit-amazon-v4').froalaEditor({
          imageUploadToS3: JSON.parse('<?php echo $hashV4; ?>'),
          fileUploadToS3: JSON.parse('<?php echo $hashV4; ?>')
        });
    });
  </script>
</body>

</html>
