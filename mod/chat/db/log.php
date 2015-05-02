<?php

/**
 * Definition of log events
 *
 * @package    mod_chat
 * @category   log
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module' => 'chat', 'action' => 'view', 'mtable' => 'chat', 'field' => 'name'),
    array('module' => 'chat', 'action' => 'add', 'mtable' => 'chat', 'field' => 'name'),
    array('module' => 'chat', 'action' => 'update', 'mtable' => 'chat', 'field' => 'name'),
    array('module' => 'chat', 'action' => 'report', 'mtable' => 'chat', 'field' => 'name'),
    array('module' => 'chat', 'action' => 'talk', 'mtable' => 'chat', 'field' => 'name'),
);
