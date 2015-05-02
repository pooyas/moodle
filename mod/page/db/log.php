<?php


/**
 * Definition of log events
 *
 * @package    mod_page
 * @category   log
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'page', 'action'=>'view', 'mtable'=>'page', 'field'=>'name'),
    array('module'=>'page', 'action'=>'view all', 'mtable'=>'page', 'field'=>'name'),
    array('module'=>'page', 'action'=>'update', 'mtable'=>'page', 'field'=>'name'),
    array('module'=>'page', 'action'=>'add', 'mtable'=>'page', 'field'=>'name'),
);