<?php

/**
 * The gradebook simple view - Database file
 *
 * @package   gradereport_singleview
 * @copyright 2014 Lion Pty Ltd (http://lion.com)
 * 
 */

$capabilities = array(

    'gradereport/singleview:view' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    )
);
