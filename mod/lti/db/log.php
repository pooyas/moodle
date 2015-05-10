<?php

/**
 * LTI web service endpoints
 *
 * @package    mod
 * @subpackage lti
 * @category   log
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module' => 'lti', 'action' => 'view', 'mtable' => 'lti', 'field' => 'name'),
    array('module' => 'lti', 'action' => 'launch', 'mtable' => 'lti', 'field' => 'name'),
    array('module' => 'lti', 'action' => 'view all', 'mtable' => 'lti', 'field' => 'name')
);