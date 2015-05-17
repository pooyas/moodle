<?php


/**
 * The mod_assign abstract base event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign abstract base event class.
 *
 * Most mod_assign events can extend this class.
 *
 */
abstract class base extends \core\event\base {

    /** @var \assign */
    protected $assign;

    /**
     * Legacy log data.
     *
     * @var array
     */
    protected $legacylogdata;

    /**
     * Set assign instance for this event.
     * @param \assign $assign
     * @throws \coding_exception
     */
    public function set_assign(\assign $assign) {
        if ($this->is_triggered()) {
            throw new \coding_exception('set_assign() must be done before triggerring of event');
        }
        if ($assign->get_context()->id != $this->get_context()->id) {
            throw new \coding_exception('Invalid assign isntance supplied!');
        }
        $this->assign = $assign;
    }

    /**
     * Get assign instance.
     *
     * NOTE: to be used from observers only.
     *
     * @throws \coding_exception
     * @return \assign
     */
    public function get_assign() {
        if ($this->is_restored()) {
            throw new \coding_exception('get_assign() is intended for event observers only');
        }
        if (!isset($this->assign)) {
            debugging('assign property should be initialised in each event', DEBUG_DEVELOPER);
            global $CFG;
            require_once($CFG->dirroot . '/mod/assign/locallib.php');
            $cm = get_coursemodule_from_id('assign', $this->contextinstanceid, 0, false, MUST_EXIST);
            $course = get_course($cm->course);
            $this->assign = new \assign($this->get_context(), $cm, $course);
        }
        return $this->assign;
    }


    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/assign/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Sets the legacy event log data.
     *
     * @param string $action The current action
     * @param string $info A detailed description of the change. But no more than 255 characters.
     * @param string $url The url to the assign module instance.
     */
    public function set_legacy_logdata($action = '', $info = '', $url = '') {
        $fullurl = 'view.php?id=' . $this->contextinstanceid;
        if ($url != '') {
            $fullurl .= '&' . $url;
        }

        $this->legacylogdata = array($this->courseid, 'assign', $action, $fullurl, $info, $this->contextinstanceid);
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        if (isset($this->legacylogdata)) {
            return $this->legacylogdata;
        }

        return null;
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        parent::validate_data();

        if ($this->contextlevel != CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        }
    }
}
