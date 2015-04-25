<?php

/**
 * Cohort UI related functions and classes.
 *
 * @package    core
 * @subpackage cohort
 * @copyright  2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/cohort/lib.php');
require_once($CFG->dirroot . '/user/selector/lib.php');


/**
 * Cohort assignment candidates
 */
class cohort_candidate_selector extends user_selector_base {
    protected $cohortid;

    public function __construct($name, $options) {
        $this->cohortid = $options['cohortid'];
        parent::__construct($name, $options);
    }

    /**
     * Candidate users
     * @param string $search
     * @return array
     */
    public function find_users($search) {
        global $DB;
        // By default wherecondition retrieves all users except the deleted, not confirmed and guest.
        list($wherecondition, $params) = $this->search_sql($search, 'u');
        $params['cohortid'] = $this->cohortid;

        $fields      = 'SELECT ' . $this->required_fields_sql('u');
        $countfields = 'SELECT COUNT(1)';

        $sql = " FROM {user} u
            LEFT JOIN {cohort_members} cm ON (cm.userid = u.id AND cm.cohortid = :cohortid)
                WHERE cm.id IS NULL AND $wherecondition";

        list($sort, $sortparams) = users_order_by_sql('u', $search, $this->accesscontext);
        $order = ' ORDER BY ' . $sort;

        if (!$this->is_validating()) {
            $potentialmemberscount = $DB->count_records_sql($countfields . $sql, $params);
            if ($potentialmemberscount > $this->maxusersperpage) {
                return $this->too_many_results($search, $potentialmemberscount);
            }
        }

        $availableusers = $DB->get_records_sql($fields . $sql . $order, array_merge($params, $sortparams));

        if (empty($availableusers)) {
            return array();
        }


        if ($search) {
            $groupname = get_string('potusersmatching', 'cohort', $search);
        } else {
            $groupname = get_string('potusers', 'cohort');
        }

        return array($groupname => $availableusers);
    }

    protected function get_options() {
        $options = parent::get_options();
        $options['cohortid'] = $this->cohortid;
        $options['file'] = 'cohort/locallib.php';
        return $options;
    }
}


/**
 * Cohort assignment candidates
 */
class cohort_existing_selector extends user_selector_base {
    protected $cohortid;

    public function __construct($name, $options) {
        $this->cohortid = $options['cohortid'];
        parent::__construct($name, $options);
    }

    /**
     * Candidate users
     * @param string $search
     * @return array
     */
    public function find_users($search) {
        global $DB;
        // By default wherecondition retrieves all users except the deleted, not confirmed and guest.
        list($wherecondition, $params) = $this->search_sql($search, 'u');
        $params['cohortid'] = $this->cohortid;

        $fields      = 'SELECT ' . $this->required_fields_sql('u');
        $countfields = 'SELECT COUNT(1)';

        $sql = " FROM {user} u
                 JOIN {cohort_members} cm ON (cm.userid = u.id AND cm.cohortid = :cohortid)
                WHERE $wherecondition";

        list($sort, $sortparams) = users_order_by_sql('u', $search, $this->accesscontext);
        $order = ' ORDER BY ' . $sort;

        if (!$this->is_validating()) {
            $potentialmemberscount = $DB->count_records_sql($countfields . $sql, $params);
            if ($potentialmemberscount > $this->maxusersperpage) {
                return $this->too_many_results($search, $potentialmemberscount);
            }
        }

        $availableusers = $DB->get_records_sql($fields . $sql . $order, array_merge($params, $sortparams));

        if (empty($availableusers)) {
            return array();
        }


        if ($search) {
            $groupname = get_string('currentusersmatching', 'cohort', $search);
        } else {
            $groupname = get_string('currentusers', 'cohort');
        }

        return array($groupname => $availableusers);
    }

    protected function get_options() {
        $options = parent::get_options();
        $options['cohortid'] = $this->cohortid;
        $options['file'] = 'cohort/locallib.php';
        return $options;
    }
}

