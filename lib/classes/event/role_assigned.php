<?php

/**
 * Role assigned event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Role assigned event.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int id: role assigned id.
 *      - string component: name of component.
 *      - int itemid: (optional) id of the item.
 * }
 *
 */
class role_assigned extends base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'role';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventroleassigned', 'role');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' assigned the role with id '$this->objectid' to the user with id " .
            "'$this->relateduserid'.";
    }

    /**
     * Returns relevant URL.
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/admin/roles/assign.php', array('contextid' => $this->contextid, 'roleid' => $this->objectid));
    }

    /**
     * Does this event replace legacy event?
     *
     * @return null|string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'role_assigned';
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return mixed
     */
    protected function get_legacy_eventdata() {
        return $this->get_record_snapshot('role_assignments', $this->other['id']);
    }

    /**
     * Returns array of parameters to be passed to legacy add_to_log() function.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $roles = get_all_roles();
        $rolenames = role_fix_names($roles, $this->get_context(), ROLENAME_ORIGINAL, true);
        return array($this->courseid, 'role', 'assign', 'admin/roles/assign.php?contextid='.$this->contextid.'&roleid='.$this->objectid,
                $rolenames[$this->objectid], '', $this->userid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->other['id'])) {
            throw new \coding_exception('The \'id\' value must be set in other.');
        }

        if (!isset($this->other['component'])) {
            throw new \coding_exception('The \'component\' value must be set in other.');
        }
    }
}
