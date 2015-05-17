<?php



/**
 * Definition of log events
 *
 * @category   log
 * @package    mod
 * @subpackage folder
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'folder', 'action'=>'view', 'mtable'=>'folder', 'field'=>'name'),
    array('module'=>'folder', 'action'=>'view all', 'mtable'=>'folder', 'field'=>'name'),
    array('module'=>'folder', 'action'=>'update', 'mtable'=>'folder', 'field'=>'name'),
    array('module'=>'folder', 'action'=>'add', 'mtable'=>'folder', 'field'=>'name'),
);