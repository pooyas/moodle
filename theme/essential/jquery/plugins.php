<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

/**
 * This file describes jQuery plugins available in the lion
 * core component. These can be included in page using:
 *   $PAGE->requires->jquery();
 *   $PAGE->requires->jquery_plugin('migrate', 'core');
 *   $PAGE->requires->jquery_plugin('ui', 'core');
 *   $PAGE->requires->jquery_plugin('ui-css', 'core');
 *
 * Please note that other lion plugins can not use the sample
 * jquery plugin names, only one is loaded if collision detected.
 *
 * Any Lion plugin may add jquery/plugins.php and include extra
 * jQuery plugins.
 *
 * Themes or other plugin may blacklist any jquery plugin,
 * for example to override default jQueryUI theme.
 */

$plugins = array(
    'bootstrap' => array('files' => array('bootstrap_2_3_2_min.js')),
    'html5shiv' => array('files' => array('html5shiv_3_7_2.js')),
    'breadcrumb' => array('files' => array('jBreadCrumb_1_1.js')),
    'fitvids' => array('files' => array('fitvids_1_1_1.js')),
    'antigravity' => array('files' => array('anti_gravity_1_1.js'))
);