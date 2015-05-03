<?php


/**
 * Definition of log events
 *
 * @package    mod_assignment
 * @category   log
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'assignment', 'action'=>'view', 'mtable'=>'assignment', 'field'=>'name'),
    array('module'=>'assignment', 'action'=>'add', 'mtable'=>'assignment', 'field'=>'name'),
    array('module'=>'assignment', 'action'=>'update', 'mtable'=>'assignment', 'field'=>'name'),
    array('module'=>'assignment', 'action'=>'view submission', 'mtable'=>'assignment', 'field'=>'name'),
    array('module'=>'assignment', 'action'=>'upload', 'mtable'=>'assignment', 'field'=>'name'),
);