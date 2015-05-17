<?php


/**
 * Definition of log events
 *
 * @category   log
 * @package    mod
 * @subpackage scorm
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module' => 'scorm', 'action' => 'view', 'mtable' => 'scorm', 'field' => 'name'),
    array('module' => 'scorm', 'action' => 'review', 'mtable' => 'scorm', 'field' => 'name'),
    array('module' => 'scorm', 'action' => 'update', 'mtable' => 'scorm', 'field' => 'name'),
    array('module' => 'scorm', 'action' => 'add', 'mtable' => 'scorm', 'field' => 'name'),
);