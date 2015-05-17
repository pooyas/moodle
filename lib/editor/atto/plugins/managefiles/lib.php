<?php


/**
 * Atto text editor manage files plugin lib.
 *
 * @package    editor
 * @subpackage atto
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Initialise the strings required for JS.
 *
 * @return void
 */
function atto_managefiles_strings_for_js() {
    global $PAGE;
    $PAGE->requires->strings_for_js(array('managefiles'), 'atto_managefiles');
}

/**
 * Sends the parameters to JS module.
 *
 * @return array
 */
function atto_managefiles_params_for_js($elementid, $options, $fpoptions) {
    global $CFG, $USER;
    require_once($CFG->dirroot . '/repository/lib.php');  // Load constants.

    // Disabled if:
    // - Not logged in or guest.
    // - Files are not allowed.
    // - Only URL are supported.
    $disabled = !isloggedin() || isguestuser() ||
            (!isset($options['maxfiles']) || $options['maxfiles'] == 0) ||
            (isset($options['return_types']) && !($options['return_types'] & ~FILE_EXTERNAL));

    $params = array('disabled' => $disabled, 'area' => array(), 'usercontext' => null);

    if (!$disabled) {
        $params['usercontext'] = context_user::instance($USER->id)->id;
        foreach (array('itemid', 'context', 'areamaxbytes', 'maxbytes', 'subdirs', 'return_types') as $key) {
            if (isset($options[$key])) {
                if ($key === 'context' && is_object($options[$key])) {
                    // Just context id is enough.
                    $params['area'][$key] = $options[$key]->id;
                } else {
                    $params['area'][$key] = $options[$key];
                }
            }
        }
    }

    return $params;
}
