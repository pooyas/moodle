<?php


/**
 * Definition of log events
 *
 * @package    mod_label
 * @category   log
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'label', 'action'=>'add', 'mtable'=>'label', 'field'=>'name'),
    array('module'=>'label', 'action'=>'update', 'mtable'=>'label', 'field'=>'name'),
);