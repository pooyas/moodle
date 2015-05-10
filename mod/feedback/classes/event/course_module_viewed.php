<?php

/**
 * The mod_feedback course module viewed event.
 *
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_feedback\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_feedback course module viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int anonymous if feedback is anonymous.
 * }
 *
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'feedback';
    }

    /**
     * Define whether a user can view the event or not. Make sure no one except admin can see details of an anonymous response.
     *
     * @deprecated since 2.7
     *
     * @param int|\stdClass $userorid ID of the user.
     * @return bool True if the user can view the event, false otherwise.
     */
    public function can_view($userorid = null) {
        global $USER;
        debugging('can_view() method is deprecated, use anonymous flag instead if necessary.', DEBUG_DEVELOPER);

        if (empty($userorid)) {
            $userorid = $USER;
        }
        if ($this->anonymous) {
            return is_siteadmin($userorid);
        } else {
            return has_capability('mod/feedback:viewreports', $this->context, $userorid);
        }
    }

    /**
     * Replace add_to_log() statement.Do this only for the case when anonymous mode is off,
     * since this is what was happening before.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        if ($this->anonymous) {
            return null;
        } else {
            return parent::get_legacy_logdata();
        }
    }

    /**
     * Custom validations.
     *
     * @throws \coding_exception in case of any problems.
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['anonymous'])) {
            throw new \coding_exception('The \'anonymous\' value must be set in other.');
        }
    }
}

