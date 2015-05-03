<?php

/**
 * Definition of log events
 *
 * @package    mod_imscp
 * @category   log
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module' => 'imscp', 'action' => 'view', 'mtable' => 'imscp', 'field' => 'name'),
    array('module' => 'imscp', 'action' => 'view all', 'mtable' => 'imscp', 'field' => 'name'),
    array('module' => 'imscp', 'action' => 'update', 'mtable' => 'imscp', 'field' => 'name'),
    array('module' => 'imscp', 'action' => 'add', 'mtable' => 'imscp', 'field' => 'name'),
);
