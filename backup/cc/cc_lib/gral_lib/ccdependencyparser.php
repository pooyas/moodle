<?php
/**
 *
 * @package backup
 * @subpackage lib
 * @copyright 2015 Pooya Saeedi
 */

require_once(dirname(__FILE__) .'/../xmlbase.php');
require_once('cssparser.php');
require_once('pathutils.php');

/**
 *
 * Older version better suited for PHP < 5.2
 * @deprecated
 * @param mixed $url
 * @return boolean
 */
function is_url_deprecated($url) {
    if (
         !preg_match('#^http\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+#i', $url) &&
         !preg_match('#^https\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+#i', $url) &&
         !preg_match('#^ftp\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+#i', $url)
        ) {
        $status = false;
    } else {
        $status = true;
    }
    return $status;
}

/**
 *
 * validates URL
 * @param string $url
 * @return boolean
 */
function is_url($url) {
    $result = filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) !== false;
    return $result;
}

function GetDepFiles($manifestroot, $fname, $folder, &$filenames) {
    static $types = array('xhtml' => true, 'html' => true, 'htm' => true);
    $extension = strtolower(trim(pathinfo($fname, PATHINFO_EXTENSION)));
    $filenames = array();
    if (isset($types[$extension])) {
        $dcx = new XMLGenericDocument();
        $filename = $manifestroot.$folder.$fname;
        if (!file_exists($filename)) {
            $filename = $manifestroot.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$fname;
        }
        if (file_exists($filename)) {
            $res = $dcx->loadHTMLFile($filename);
            if ($res) {
                GetDepFilesHTML($manifestroot, $fname, $filenames, $dcx, $folder);
            }
        }
    }
}

function GetDepFilesHTML($manifestroot, $fname, &$filenames, &$dcx, $folder) {
    $dcx->resetXpath();
    $nlist         = $dcx->nodeList("//img/@src | //link/@href | //script/@src | //a[not(starts-with(@href,'#'))]/@href");
    $css_obj_array = array();
    foreach ($nlist as $nl) {
        $item       = $folder.$nl->nodeValue;
        $path_parts = pathinfo($item);
        $fname      = $path_parts['basename'];
        $ext        = array_key_exists('extension', $path_parts) ? $path_parts['extension'] : '';
        if (!is_url($folder.$nl->nodeValue) && !is_url($nl->nodeValue)) {
            $path = $folder.$nl->nodeValue;
            $file = fullPath($path, "/");
            toNativePath($file);
            if (file_exists($manifestroot.DIRECTORY_SEPARATOR.$file)) {
                $filenames[$file] = $file;
            }
        }
        if ($ext == 'css') {
            $css = new cssparser();
            $css->Parse($dcx->filePath().$nl->nodeValue);
            $css_obj_array[$item] = $css;
        }
    }
    $nlist = $dcx->nodeList("//*/@class");
    foreach ($nlist as $nl) {
        $item = $folder.$nl->nodeValue;
        foreach ($css_obj_array as $csskey => $cssobj) {
            $bimg  = $cssobj->Get($item, "background-image");
            $limg  = $cssobj->Get($item, "list-style-image");
            $npath = pathinfo($csskey);
            if ((!empty($bimg)) && ($bimg != 'none')) {
                $value             = stripUrl($bimg, $npath['dirname'].'/');
                $filenames[$value] = $value;
            } else if ((!empty($limg)) && ($limg != 'none')) {
                $value             = stripUrl($limg, $npath['dirname'].'/');
                $filenames[$value] = $value;
            }
        }
    }
    $elems_to_check = array("body", "p", "ul", "h4", "a", "th");
    $do_we_have_it  = array();
    foreach ($elems_to_check as $elem) {
        $do_we_have_it[$elem] = ($dcx->nodeList("//".$elem)->length > 0);
    }
    foreach ($elems_to_check as $elem) {
        if ($do_we_have_it[$elem]) {
            foreach ($css_obj_array as $csskey => $cssobj) {
                $sb    = $cssobj->Get($elem, "background-image");
                $sbl   = $cssobj->Get($elem, "list-style-image");
                $npath = pathinfo($csskey);
                if ((!empty($sb)) && ($sb != 'none')) {
                    $value             = stripUrl($sb, $npath['dirname'].'/');
                    $filenames[$value] = $value;
                } else if ((!empty($sbl)) && ($sbl != 'none')) {
                    $value             = stripUrl($sbl, $npath['dirname'].'/');
                    $filenames[$value] = $value;
                }
            }
        }
    }
}