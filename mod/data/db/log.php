<?php


/**
 * Definition of log events
 *
 * @package    mod
 * @subpackage data
 * @category   log
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'data', 'action'=>'view', 'mtable'=>'data', 'field'=>'name'),
    array('module'=>'data', 'action'=>'add', 'mtable'=>'data', 'field'=>'name'),
    array('module'=>'data', 'action'=>'update', 'mtable'=>'data', 'field'=>'name'),
    array('module'=>'data', 'action'=>'record delete', 'mtable'=>'data', 'field'=>'name'),
    array('module'=>'data', 'action'=>'fields add', 'mtable'=>'data_fields', 'field'=>'name'),
    array('module'=>'data', 'action'=>'fields update', 'mtable'=>'data_fields', 'field'=>'name'),
    array('module'=>'data', 'action'=>'templates saved', 'mtable'=>'data', 'field'=>'name'),
    array('module'=>'data', 'action'=>'templates def', 'mtable'=>'data', 'field'=>'name'),
);