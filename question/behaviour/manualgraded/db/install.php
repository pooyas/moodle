<?php

/**
 * Post-install script for manual graded question behaviour.
 * @package   qbehaviour_manualgraded
 * @copyright 2013 The Open Universtiy
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Post-install script
 */
function xmldb_qbehaviour_manualgraded_install() {

    // Hide the manualgraded behaviour from the list of behaviours that users
    // can select in the user-interface. If a user accidentally chooses manual
    // graded behaviour for a quiz, there is no way to get the questions automatically
    // graded after the student has answered them. If teachers really want to do
    // this they can ask their admin to enable it on the manage behaviours
    // screen in the UI.
    $disabledbehaviours = get_config('question', 'disabledbehaviours');
    if (!empty($disabledbehaviours)) {
        $disabledbehaviours = explode(',', $disabledbehaviours);
    } else {
        $disabledbehaviours = array();
    }
    if (array_search('manualgraded', $disabledbehaviours) === false) {
        $disabledbehaviours[] = 'manualgraded';
        set_config('disabledbehaviours', implode(',', $disabledbehaviours), 'question');
    }
}
