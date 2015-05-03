<?php

/**
 * This file describes jQuery plugins available in the Lion
 * core component. These can be included in page using:
 *   $PAGE->requires->jquery();
 *   $PAGE->requires->jquery_plugin('migrate');
 *   $PAGE->requires->jquery_plugin('ui');
 *   $PAGE->requires->jquery_plugin('ui-css');
 *
 * Please note that other lion plugins can not use the same
 * jquery plugin names, only one is loaded if collision detected.
 *
 * Any Lion plugin may add jquery/plugins.php that defines extra
 * jQuery plugins.
 *
 * Themes and other plugins may override any jquery plugin,
 * for example to override default jQueryUI theme.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi  
 * 
 */

$plugins = array(
    'jquery'  => array('files' => array('jquery-1.11.1.min.js')),
    'migrate' => array('files' => array('jquery-migrate-1.2.1.min.js')),
    'ui'      => array('files' => array('ui-1.11.1/jquery-ui.min.js')),
    'ui-css'  => array('files' => array('ui-1.11.1/theme/smoothness/jquery-ui.min.css')),
);
