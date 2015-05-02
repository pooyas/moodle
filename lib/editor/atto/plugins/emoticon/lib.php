<?php

/**
 * Atto text editor emoticon plugin lib.
 *
 * @package    atto_emoticon
 * @copyright  2014 Frédéric Massart
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise the strings required for JS.
 *
 * @return void
 */
function atto_emoticon_strings_for_js() {
    global $PAGE;

    $PAGE->requires->strings_for_js(array('insertemoticon'), 'atto_emoticon');

    // Load the strings required by the emotes.
    $manager = get_emoticon_manager();
    foreach ($manager->get_emoticons() as $emote) {
        $PAGE->requires->string_for_js($emote->altidentifier, $emote->altcomponent);
    }
}

/**
 * Sends the parameters to JS module.
 *
 * @return array
 */
function atto_emoticon_params_for_js($elementid, $options, $fpoptions) {
    $manager = get_emoticon_manager();
    return array(
        'emoticons' => $manager->get_emoticons()
    );
}
