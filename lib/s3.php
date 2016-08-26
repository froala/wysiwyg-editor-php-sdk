<?php

namespace FroalaEditor;

class S3 {

  /**
  *
  * @param config:
  *   (
  *     timezone => 'Europe/Bucharest',
  *     bucket => 'bucketName',
  *     region => 's3',
  *     keyStart => 'editor/',
  *     acl => 'public-read',
  *     accessKey => 'YOUR-AMAZON-S3-PUBLIC-ACCESS-KEY',
  *     secretKey => 'YOUR-AMAZON-S3-SECRET-ACCESS-KEY'
  *   )
  *
  * @return:
  *   (
  *     bucket => bucket,
  *     region => region,
  *     keyStart => keyStart,
  *     params => (
  *       acl => acl,
  *       AWSAccessKeyId => accessKeyId,
  *       policy => policy,
  *       signature => signature,
  *     )
  *   )
  */
  public static function getHashV2($config) {

    // Set date timezone.
    date_default_timezone_set($config['timezone']);

    // important variables that will be used throughout this example
    $bucket = $config['bucket'];
    $region = $config['region'];
    $keyStart = $config['keyStart'];
    $acl = $config['acl'];

    // these can be found on your Account page, under Security Credentials > Access Keys
    $accessKeyId = $config['accessKey'];
    $secret = $config['secretKey'];

    $policy = base64_encode(json_encode(array(
        // ISO 8601 - date('c'); generates uncompatible date, so better do it manually
        'expiration' => date('Y-m-d\TH:i:s.000\Z', strtotime('+1 day')),
        'conditions' => array(
            array('bucket' => $bucket),
            array('acl' => $acl),
            array('success_action_status' => '201'),
            array('x-requested-with' => 'xhr'),
            array('starts-with', '$key', $keyStart),
            array('starts-with', '$Content-Type', '') // accept all files
        )
    )));

    $signature = base64_encode(hash_hmac('sha1', $policy, $secret, true));

    $response = new \StdClass;
    $response->bucket = $bucket;
    $response->region = $region;
    $response->keyStart = $keyStart;
    $response->params = new \StdClass;
    $response->params->acl = $acl;
    $response->params->AWSAccessKeyId = $accessKeyId;
    $response->params->policy = $policy;
    $response->params->signature = $signature;

    return $response;
  }
}


?>