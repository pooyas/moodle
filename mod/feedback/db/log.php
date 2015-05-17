<?php


/**
 * Definition of log events
 *
 * @category   log
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'feedback', 'action'=>'startcomplete', 'mtable'=>'feedback', 'field'=>'name'),
    array('module'=>'feedback', 'action'=>'submit', 'mtable'=>'feedback', 'field'=>'name'),
    array('module'=>'feedback', 'action'=>'delete', 'mtable'=>'feedback', 'field'=>'name'),
    array('module'=>'feedback', 'action'=>'view', 'mtable'=>'feedback', 'field'=>'name'),
    array('module'=>'feedback', 'action'=>'view all', 'mtable'=>'course', 'field'=>'shortname'),
);