<?php



/**
 * This file is part of the Database module for Lion
 *
 * @package    mod
 * @subpackage data
 * @copyright  2015 Pooya Saeedi
 */

define('NO_LION_COOKIES', true); // session not used here

require_once('../../config.php');

$d = optional_param('d', 0, PARAM_INT);   // database id

$PAGE->set_url('/mod/data/js.php', array('d'=>$d));

$lifetime  = 600;                                   // Seconds to cache this stylesheet

if ($data = $DB->get_record('data', array('id'=>$d))) {
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
    header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $lifetime) . ' GMT');
    header('Cache-control: max_age = '. $lifetime);
    header('Pragma: ');
    header('Content-type: text/css; charset=utf-8');  // Correct MIME type

    echo $data->jstemplate;
}