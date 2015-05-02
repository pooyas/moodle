<?php

/**
 * Callback for equella repository.
 *
 * @since Lion 2.3
 * @package   repository_equella
 * @copyright 2012 Dongsheng Cai {@link http://dongsheng.org}
 * 
 */
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
$json = required_param('tlelinks', PARAM_RAW);

require_login();

$decodedinfo = json_decode($json);
$info = array_pop($decodedinfo);

$url = '';
if (isset($info->url)) {
    $url = s(clean_param($info->url, PARAM_URL));
}

$filename = '';
// Use $info->filename if exists, $info->name is a display name,
// it may not have extension
if (isset($info->filename)) {
    $filename  = s(clean_param($info->filename, PARAM_FILE));
} else if (isset($info->name)) {
    $filename  = s(clean_param($info->name, PARAM_FILE));
}

$thumbnail = '';
if (isset($info->thumbnail)) {
    $thumbnail = s(clean_param($info->thumbnail, PARAM_URL));
}

$author = '';
if (isset($info->owner)) {
    $author = s(clean_param($info->owner, PARAM_NOTAGS));
}

$license = '';
if (isset($info->license)) {
    $license = s(clean_param($info->license, PARAM_ALPHAEXT));
}

$source = base64_encode(json_encode(array('url'=>$url,'filename'=>$filename)));

$js =<<<EOD
<html>
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
    window.onload = function() {
        var resource = {};
        resource.title = "$filename";
        resource.source = "$source";
        resource.thumbnail = '$thumbnail';
        resource.author = "$author";
        resource.license = "$license";
        parent.M.core_filepicker.select_file(resource);
    }
    </script>
</head>
<body><noscript></noscript></body>
</html>
EOD;

header('Content-Type: text/html; charset=utf-8');
die($js);
