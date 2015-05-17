<?php


/**
 * @package    mod
 * @subpackage assignment
 * @copyright  2015 Pooya Saeedi
*/

require_once("../../config.php");

$id = required_param('id', PARAM_INT);

// Rest in peace old assignment!
redirect(new lion_url('/mod/assign/index.php', array('id' => $id)));
