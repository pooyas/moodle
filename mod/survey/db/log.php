<?php


/**
 * Definition of log events
 *
 * @package    mod
 * @subpackage survey
 * @category   log
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'survey', 'action'=>'add', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'update', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'download', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'view form', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'view graph', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'view report', 'mtable'=>'survey', 'field'=>'name'),
    array('module'=>'survey', 'action'=>'submit', 'mtable'=>'survey', 'field'=>'name'),
);