<?php


/**
 * Definition of log events
 *
 * @package    mod_folder
 * @category   log
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'folder', 'action'=>'view', 'mtable'=>'folder', 'field'=>'name'),
    array('module'=>'folder', 'action'=>'view all', 'mtable'=>'folder', 'field'=>'name'),
    array('module'=>'folder', 'action'=>'update', 'mtable'=>'folder', 'field'=>'name'),
    array('module'=>'folder', 'action'=>'add', 'mtable'=>'folder', 'field'=>'name'),
);