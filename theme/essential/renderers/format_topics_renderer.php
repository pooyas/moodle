<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

include_once($CFG->dirroot . "/course/format/topics/renderer.php");

class theme_essential_format_topics_renderer extends format_topics_renderer
{
    public function start_section_list()
    {
        return parent::start_section_list();
    }

    public function end_section_list()
    {
        return parent::end_section_list();
    }

    public function get_nav_links($course, $sections, $sectionno)
    {
        return theme_essential_get_nav_links($course, $sections, $sectionno);
    }

    public function section_left_content($section, $course, $onsectionpage)
    {
        return parent::section_left_content($section, $course, $onsectionpage);
    }

    public function section_right_content($section, $course, $onsectionpage)
    {
        return parent::section_right_content($section, $course, $onsectionpage);
    }

    public function section_header($section, $course, $onsectionpage, $sectionreturn = null)
    {
        return parent::section_header($section, $course, $onsectionpage, $sectionreturn);
    }

    public function section_footer()
    {
        return parent::section_footer();
    }

    public function section_availability_message($section, $canviewhidden)
    {
        return parent::section_availability_message($section, $canviewhidden);
    }

    public function course_activity_clipboard($course, $sectionno = null)
    {
        return parent::course_activity_clipboard($course, $sectionno);
    }

    public function format_summary_text($section)
    {
        return parent::format_summary_text($section);
    }

    public function print_single_section_page($course, $sections, $mods, $modnames, $modnamesused, $displaysection)
    {
        return theme_essential_print_single_section_page($this, $this->courserenderer, $course, $sections, $mods, $modnames, $modnamesused, $displaysection);
    }
}