<?php


/**
 * HTML import lib
 *
 * @package    mod
 * @subpackage book
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

/**
 * Adds module specific settings to the settings block
 *
 * @param settings_navigation $settings The settings navigation object
 * @param navigation_node $node The node to add module settings to
 */
function booktool_importhtml_extend_settings_navigation(settings_navigation $settings, navigation_node $node) {
    global $PAGE;

    if (has_capability('booktool/importhtml:import', $PAGE->cm->context)) {
        $url = new lion_url('/mod/book/tool/importhtml/index.php', array('id'=>$PAGE->cm->id));
        $node->add(get_string('import', 'booktool_importhtml'), $url, navigation_node::TYPE_SETTING, null, null, null);
    }
}
