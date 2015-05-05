<?php

/**
 * @package    calendartype
 * @subpackage gregorian
 * @copyright  2015 Pooya Saeedi
 */

require('../config.php');
$PAGE->set_url('/calendar/view.php');
redirect($CFG->wwwroot.'/calendar/view.php');