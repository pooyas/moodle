<?php


/**
 * Librería de funciones básicas V1.0 (June, 16th 2009)
 *
 *
 * @link daniel.muhlrad@uvcms.com
 * @version 1.0
 *
 * @package    backup
 * @subpackage cc
 * @copyright  2015 Pooya Saeedi
 */




/**
 * Make a Handler error with an exception msg error
 *
 * @param integer $errno
 * @param string $errstr
 * @param string $errfile
 * @param string $errline
 */
function errorHandler($errno, $errstr, $errfile, $errline) {
    // si deseas podes guardarlos en un archivo
    ($errfile);($errline);
    throw new Exception($errstr, $errno);
}



/**
 * Return de mime-type of a file
 *
 * @param string $file
 * @param string $default_type
 *
 */
function file_mime_type ($file, $default_type = 'application/octet-stream'){
    $ftype = $default_type;
    $magic_path =   dirname(__FILE__)
                  . DIRECTORY_SEPARATOR
                  . '..'
                  . DIRECTORY_SEPARATOR
                  . 'magic'
                  . DIRECTORY_SEPARATOR
                  . 'magic';
    $finfo = @finfo_open(FILEINFO_MIME , $magic_path);
    if ($finfo !== false) {

        $fres = @finfo_file($finfo, $file);

        if ( is_string($fres) && !empty($fres) ) {
            $ftype = $fres;
        }
        @finfo_close($finfo);
    }
    return $ftype;
}




function array_remove_by_value($arr,$value) {
    return array_values(array_diff($arr,array($value)));

}


function array_remove_by_key($arr,$key) {
    return array_values(array_diff_key($arr,array($key)));

}


function cc_print_object($object) {
    echo '<pre>' . htmlspecialchars(print_r($object,true)) . '</pre>';
}



/**
 * IndexOf - first version of find an element in the Array given
 * returns the index of the *first* occurance
 * @param mixed $needle
 * @param array $haystack
 * @return mixed The element or false if the function didnt find it
 */

function indexOf($needle, $haystack) {
    for ($i = 0; $i < count($haystack) ; $i++) {
            if ($haystack[$i] == $needle) {
                return $i;
            }
    }
    return false;
}


/**
 * IndexOf2 - second version of find an element in the Array given
 *
 * @param mixed $needle
 * @param array $haystack
 * @return mixed The index of the element or false if the function didnt find it
 */

function indexOf2($needle, $haystack) {
    for($i = 0,$z = count($haystack); $i < $z; $i++){
        if ($haystack[$i] == $needle) {  //finds the needle
            return $i;
        }
    }
    return false;
}

