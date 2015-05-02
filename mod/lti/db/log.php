<?php

/**
 * LTI web service endpoints
 *
 * @package    mod_lti
 * @category   log
 * @copyright  Copyright (c) 2011 Lionrooms Inc. (http://www.lionrooms.com)
 * 
 * @author     Chris Scribner
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module' => 'lti', 'action' => 'view', 'mtable' => 'lti', 'field' => 'name'),
    array('module' => 'lti', 'action' => 'launch', 'mtable' => 'lti', 'field' => 'name'),
    array('module' => 'lti', 'action' => 'view all', 'mtable' => 'lti', 'field' => 'name')
);