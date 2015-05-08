<?php

/**
 * Question category created event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Question category created event class.
 *
 */
class question_category_created extends base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'question_categories';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventquestioncategorycreated', 'question');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' created the question category with id '$this->objectid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        if ($this->courseid) {
            $cat = $this->objectid . ',' . $this->contextid;
            if ($this->contextlevel == CONTEXT_MODULE) {
                return new \lion_url('/question/edit.php', array('cmid' => $this->contextinstanceid, 'cat' => $cat));
            }
            return new \lion_url('/question/edit.php', array('courseid' => $this->courseid, 'cat' => $cat));
        }

        // Bad luck, there does not seem to be any simple intelligent way
        // to go to specific question category in context above course,
        // let's try to edit it from frontpage which may surprisingly work.
        return new \lion_url('/question/category.php', array('courseid' => SITEID, 'edit' => $this->objectid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        if ($this->contextlevel == CONTEXT_MODULE) {
            return array($this->courseid, 'quiz', 'addcategory', 'view.php?id=' . $this->contextinstanceid,
                $this->objectid, $this->contextinstanceid);
        }
        // This is not related to individual quiz at all.
        return null;
    }
}
