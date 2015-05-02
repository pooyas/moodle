<?php


/**
 * Definition of log events
 *
 * @package    mod_choice
 * @category   log
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'choice', 'action'=>'view', 'mtable'=>'choice', 'field'=>'name'),
    array('module'=>'choice', 'action'=>'update', 'mtable'=>'choice', 'field'=>'name'),
    array('module'=>'choice', 'action'=>'add', 'mtable'=>'choice', 'field'=>'name'),
    array('module'=>'choice', 'action'=>'report', 'mtable'=>'choice', 'field'=>'name'),
    array('module'=>'choice', 'action'=>'choose', 'mtable'=>'choice', 'field'=>'name'),
    array('module'=>'choice', 'action'=>'choose again', 'mtable'=>'choice', 'field'=>'name'),
);