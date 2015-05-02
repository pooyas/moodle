<?php


/**
 * This file is part of the Database module for Lion
 *
 * @copyright 2005 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package mod_data
 */

define('NO_LION_COOKIES', true); // session not used here

require_once('../../config.php');

$d = optional_param('d', 0, PARAM_INT);   // database id
$lifetime  = 600;                                   // Seconds to cache this stylesheet

$PAGE->set_url('/mod/data/css.php', array('d'=>$d));

if ($data = $DB->get_record('data', array('id'=>$d))) {
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
    header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $lifetime) . ' GMT');
    header('Cache-control: max_age = '. $lifetime);
    header('Pragma: ');
    header('Content-type: text/css; charset=utf-8');  // Correct MIME type

    echo $data->csstemplate;
}