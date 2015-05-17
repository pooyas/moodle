<?php


/**
 * Definition of log events
 *
 * @category   log
 * @package    mod
 * @subpackage chat
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module' => 'chat', 'action' => 'view', 'mtable' => 'chat', 'field' => 'name'),
    array('module' => 'chat', 'action' => 'add', 'mtable' => 'chat', 'field' => 'name'),
    array('module' => 'chat', 'action' => 'update', 'mtable' => 'chat', 'field' => 'name'),
    array('module' => 'chat', 'action' => 'report', 'mtable' => 'chat', 'field' => 'name'),
    array('module' => 'chat', 'action' => 'talk', 'mtable' => 'chat', 'field' => 'name'),
);
