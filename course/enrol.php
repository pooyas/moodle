<?php

/**
 * Redirection of old enrol entry point.
 *
 * @package core
 * @subpackage course
 * @copyright 2015 Pooya Saeedi
 */

// Note:
// Renaming required

require('../config.php');

$id = required_param('id', PARAM_INT);

redirect(new moodle_url('/enrol/index.php', array('id'=>$id)));
