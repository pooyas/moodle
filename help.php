<?php


/**
 * Displays help via AJAX call or in a new page
 *
 * Use {@link core_renderer::help_icon()} or {@link addHelpButton()} to display
 * the help icon.
 *
 * @copyright 2002 onwards Martin Dougiamas
 * @package   core
 * 
 */

define('NO_LION_COOKIES', true);

require_once(dirname(__FILE__) . '/config.php');

$identifier = required_param('identifier', PARAM_STRINGID);
$component  = required_param('component', PARAM_COMPONENT);
$lang       = optional_param('lang', 'en', PARAM_LANG);

// We don't actually modify the session here as we have NO_LION_COOKIES set.
$SESSION->lang = $lang;

$PAGE->set_url('/help.php');
$PAGE->set_pagelayout('popup');
$PAGE->set_context(context_system::instance());

$data = get_formatted_help_string($identifier, $component, false);
if (!empty($data->heading)) {
    $PAGE->set_title($data->heading);
} else {
    $PAGE->set_title(get_string('help'));
}
echo $OUTPUT->header();
if (!empty($data->heading)) {
    echo $OUTPUT->heading($data->heading, 1, 'helpheading');
}
echo $data->text;
if (isset($data->completedoclink)) {
    echo $data->completedoclink;
}
echo $OUTPUT->footer();
