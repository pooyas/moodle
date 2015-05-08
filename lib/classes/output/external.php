<?php

/**
 * Mustache helper to load strings from string_manager.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\output;

use external_api;
use external_function_parameters;
use external_value;
use core_component;
use lion_exception;
use context_system;
use theme_config;

/**
 * This class contains a list of webservice functions related to output.
 *
 */
class external extends external_api {
    /**
     * Returns description of load_template() parameters.
     *
     * @return external_function_parameters
     */
    public static function load_template_parameters() {
        return new external_function_parameters(
                array('component' => new external_value(PARAM_COMPONENT, 'component containing the template'),
                      'template' => new external_value(PARAM_ALPHANUMEXT, 'name of the template'),
                      'themename' => new external_value(PARAM_ALPHANUMEXT, 'The current theme.'),
                         )
            );
    }

    /**
     * Can this function be called directly from ajax?
     *
     * @return boolean
     * @since Lion 2.9
     */
    public static function load_template_is_allowed_from_ajax() {
        return true;
    }

    /**
     * Return a mustache template, and all the strings it requires.
     *
     * @param string $component The component that holds the template.
     * @param string $templatename The name of the template.
     * @param string $themename The name of the current theme.
     * @return string the template
     */
    public static function load_template($component, $template, $themename) {
        global $DB, $CFG, $PAGE;

        $params = self::validate_parameters(self::load_template_parameters(),
                                            array('component' => $component,
                                                  'template' => $template,
                                                  'themename' => $themename));

        $component = $params['component'];
        $template = $params['template'];
        $themename = $params['themename'];

        // Check if this is a valid component.
        $componentdir = core_component::get_component_directory($component);
        if (empty($componentdir)) {
            throw new lion_exception('filenotfound', 'error');
        }
        // Places to look.
        $candidates = array();
        // Theme dir.
        $root = $CFG->dirroot;

        $themeconfig = theme_config::load($themename);

        $candidate = "${root}/theme/${themename}/templates/${component}/${template}.mustache";
        $candidates[] = $candidate;
        // Theme parents dir.
        foreach ($themeconfig->parents as $theme) {
            $candidate = "${root}/theme/${theme}/templates/${component}/${template}.mustache";
            $candidates[] = $candidate;
        }
        // Component dir.
        $candidate = "${componentdir}/templates/${template}.mustache";
        $candidates[] = $candidate;
        $templatestr = false;
        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                $templatestr = file_get_contents($candidate);
                break;
            }
        }
        if ($templatestr === false) {
            throw new lion_exception('filenotfound', 'error');
        }

        return $templatestr;
    }

    /**
     * Returns description of load_template() result value.
     *
     * @return external_description
     */
    public static function load_template_returns() {
        return new external_value(PARAM_RAW, 'template');
    }
}

