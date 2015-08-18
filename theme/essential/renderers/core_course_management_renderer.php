<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

require_once($CFG->dirroot . "/course/classes/management_renderer.php");

class theme_essential_core_course_management_renderer extends core_course_management_renderer {

    /**
     * Renderers a key value pair of information for display.
     *
     * @param string $key
     * @param string $value
     * @param string $class
     * @return string
     */
    protected function detail_pair($key, $value, $class ='') {
        $html = html_writer::start_div('detail-pair row yui3-g '.preg_replace('#[^a-zA-Z0-9_\-]#', '-', $class));
        $html .= html_writer::div(html_writer::span($key), 'pair-key span4 yui3-u-1-4');
        $html .= html_writer::div(html_writer::span($value), 'pair-value span8 yui3-u-3-4');
        $html .= html_writer::end_div();
        return $html;
    }
}