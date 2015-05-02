<?php


/**
 * Definition of log events
 *
 * @package    mod_url
 * @category   log
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'url', 'action'=>'view', 'mtable'=>'url', 'field'=>'name'),
    array('module'=>'url', 'action'=>'view all', 'mtable'=>'url', 'field'=>'name'),
    array('module'=>'url', 'action'=>'update', 'mtable'=>'url', 'field'=>'name'),
    array('module'=>'url', 'action'=>'add', 'mtable'=>'url', 'field'=>'name'),
);