<?php



/**
 * Redirection of old enrol entry point.
 *
 * @package    core
 * @subpackage course
 * @copyright  2015 Pooya Saeedi
 */

require('../config.php');

$id = required_param('id', PARAM_INT);

redirect(new lion_url('/enrol/index.php', array('id'=>$id)));
