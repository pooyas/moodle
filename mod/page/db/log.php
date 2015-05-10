<?php


/**
 * Definition of log events
 *
 * @package    mod
 * @subpackage page
 * @category   log
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'page', 'action'=>'view', 'mtable'=>'page', 'field'=>'name'),
    array('module'=>'page', 'action'=>'view all', 'mtable'=>'page', 'field'=>'name'),
    array('module'=>'page', 'action'=>'update', 'mtable'=>'page', 'field'=>'name'),
    array('module'=>'page', 'action'=>'add', 'mtable'=>'page', 'field'=>'name'),
);