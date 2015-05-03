<?php

/**
 * Web interface to list and filter steps
 *
 * @package    tool
 * @subpackage behat
 * @copyright  2015 Pooya Saeedi
 * 
 */

require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/tool/behat/locallib.php');
require_once($CFG->libdir . '/behat/classes/behat_config_manager.php');

// This page usually takes an exceedingly long time to load, so we need to
// increase the time limit. At present it takes about a minute on some
// systems, but let's allow room for expansion.
core_php_time_limit::raise(300);

$filter = optional_param('filter', '', PARAM_ALPHANUMEXT);
$type = optional_param('type', false, PARAM_ALPHAEXT);
$component = optional_param('component', '', PARAM_ALPHAEXT);

admin_externalpage_setup('toolbehat');

// Getting available steps definitions from behat.
$steps = tool_behat::stepsdefinitions($type, $component, $filter);

// Form.
$componentswithsteps = array('' => get_string('allavailablesteps', 'tool_behat'));

// Complete the components list with the lion steps definitions.
$components = behat_config_manager::get_components_steps_definitions();
if ($components) {
    foreach ($components as $component => $filepath) {
        // TODO Use a class static attribute instead of the class name.
        $componentswithsteps[$component] = 'Lion ' . substr($component, 6);
    }
}
$form = new steps_definitions_form(null, array('components' => $componentswithsteps));

// Output contents.
$renderer = $PAGE->get_renderer('tool_behat');
echo $renderer->render_stepsdefinitions($steps, $form);

