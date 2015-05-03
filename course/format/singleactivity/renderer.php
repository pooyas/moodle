<?php

/**
 * Renderer for outputting the singleactivity course format.
 *
 * @package    format_singleactivity
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Basic renderer for singleactivity format.
 *
 * @package    format_singleactivity
 * @copyright  2015 Pooya Saeedi
 * 
 */
class format_singleactivity_renderer extends plugin_renderer_base {

    /**
     * Displays the activities list in cases when course view page is not
     * redirected to the activity page.
     *
     * @param stdClass $course record from table course
     * @param bool $orphaned if false displays the main activity (if present)
     *     if true displays all other activities
     */
    public function display($course, $orphaned) {
        $courserenderer = $this->page->get_renderer('core', 'course');
        $output = '';
        $modinfo = get_fast_modinfo($course);
        if ($orphaned) {
            if (!empty($modinfo->sections[1])) {
                $output .= $this->output->heading(get_string('orphaned', 'format_singleactivity'), 3, 'sectionname');
                $output .= $this->output->box(get_string('orphanedwarning', 'format_singleactivity'));
                $output .= $courserenderer->course_section_cm_list($course, 1, 1);
            }
        } else {
            $output .= $courserenderer->course_section_cm_list($course, 0, 0);
            if (empty($modinfo->sections[0]) && course_get_format($course)->activity_has_subtypes()) {
                // Course format was unable to automatically redirect to add module page.
                $output .= $courserenderer->course_section_add_cm_control($course, 0, 0);
            }
        }
        return $output;
    }
}
