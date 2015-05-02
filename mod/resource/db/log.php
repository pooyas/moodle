<?php


/**
 * Definition of log events
 *
 * @package    mod_resource
 * @category   log
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'resource', 'action'=>'view', 'mtable'=>'resource', 'field'=>'name'),
    array('module'=>'resource', 'action'=>'view all', 'mtable'=>'resource', 'field'=>'name'),
    array('module'=>'resource', 'action'=>'update', 'mtable'=>'resource', 'field'=>'name'),
    array('module'=>'resource', 'action'=>'add', 'mtable'=>'resource', 'field'=>'name'),
);