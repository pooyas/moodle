<?php

/**
 * Renderer for outputting the weeks course format.
 *
 * @package format_weeks
 * @copyright 2015 Pooya Saeedi
 * 
 * @since Lion 2.3
 */


defined('LION_INTERNAL') || die();
require_once($CFG->dirroot.'/course/format/renderer.php');
require_once($CFG->dirroot.'/course/format/weeks/lib.php');


/**
 * Basic renderer for weeks format.
 *
 * @copyright 2015 Pooya Saeedi
 * 
 */
class format_weeks_renderer extends format_section_renderer_base {
    /**
     * Generate the starting container html for a list of sections
     * @return string HTML to output.
     */
    protected function start_section_list() {
        return html_writer::start_tag('ul', array('class' => 'weeks'));
    }

    /**
     * Generate the closing container html for a list of sections
     * @return string HTML to output.
     */
    protected function end_section_list() {
        return html_writer::end_tag('ul');
    }

    /**
     * Generate the title for this section page
     * @return string the page title
     */
    protected function page_title() {
        return get_string('weeklyoutline');
    }
}
