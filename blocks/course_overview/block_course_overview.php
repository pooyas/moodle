<?php


/**
 * Course overview block
 *
 * @package    blocks
 * @subpackage course_overview
 * @copyright  2015 Pooya Saeedi
 */
require_once($CFG->dirroot.'/blocks/course_overview/locallib.php');

/**
 * Course overview block
 *
 */
class block_course_overview extends block_base {
    /**
     * If this is passed as mynumber then showallcourses, irrespective of limit by user.
     */
    const SHOW_ALL_COURSES = -2;

    /**
     * Block initialization
     */
    public function init() {
        $this->title   = get_string('pluginname', 'block_course_overview');
    }

    /**
     * Return contents of course_overview block
     *
     * @return stdClass contents of block
     */
    public function get_content() {
        global $USER, $CFG, $DB;
        require_once($CFG->dirroot.'/user/profile/lib.php');

        if($this->content !== NULL) {
            return $this->content;
        }

        $config = get_config('block_course_overview');

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        $content = array();

        $updatemynumber = optional_param('mynumber', -1, PARAM_INT);
        if ($updatemynumber >= 0) {
            block_course_overview_update_mynumber($updatemynumber);
        }

        profile_load_custom_fields($USER);

        $showallcourses = ($updatemynumber === self::SHOW_ALL_COURSES);
        list($sortedcourses, $sitecourses, $totalcourses) = block_course_overview_get_sorted_courses($showallcourses);
        $overviews = block_course_overview_get_overviews($sitecourses);

        $renderer = $this->page->get_renderer('block_course_overview');
        if (!empty($config->showwelcomearea)) {
            require_once($CFG->dirroot.'/message/lib.php');
            $msgcount = message_count_unread_messages();
            $this->content->text = $renderer->welcome_area($msgcount);
        }

        // Number of sites to display.
        if ($this->page->user_is_editing() && empty($config->forcedefaultmaxcourses)) {
            $this->content->text .= $renderer->editing_bar_head($totalcourses);
        }

        if (empty($sortedcourses)) {
            $this->content->text .= get_string('nocourses','my');
        } else {
            // For each course, build category cache.
            $this->content->text .= $renderer->course_overview($sortedcourses, $overviews);
            $this->content->text .= $renderer->hidden_courses($totalcourses - count($sortedcourses));
        }

        return $this->content;
    }

    /**
     * Allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }

    /**
     * Locations where block can be displayed
     *
     * @return array
     */
    public function applicable_formats() {
        return array('my-index' => true);
    }

    /**
     * Sets block header to be hidden or visible
     *
     * @return bool if true then header will be visible.
     */
    public function hide_header() {
        // Hide header if welcome area is show.
        $config = get_config('block_course_overview');
        return !empty($config->showwelcomearea);
    }
}