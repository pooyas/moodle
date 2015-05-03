<?php

/**
 * Reader helper trait.
 *
 * @package    tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace tool_log\helper;

defined('LION_INTERNAL') || die();

/**
 * Reader helper trait.
 * \tool_log\helper\store must be included before using this trait.
 *
 *
 * @property string $component Frankenstyle plugin name initialised in store trait.
 * @property string $store short plugin name initialised in store trait.
 */
trait reader {
    /**
     * Default get name api.
     *
     * @return string name of the store.
     */
    public function get_name() {
        if (get_string_manager()->string_exists('pluginname', $this->component)) {
            return get_string('pluginname', $this->component);
        }
        return $this->store;
    }

    /**
     * Default get description method.
     *
     * @return string description of the store.
     */
    public function get_description() {
        if (get_string_manager()->string_exists('pluginname_desc', $this->component)) {
            return get_string('pluginname_desc', $this->component);
        }
        return $this->store;
    }

    /**
     * Adds ID column to $sort to make sure events from one request
     * within 1 second are returned in the same order.
     *
     * @param string $sort
     * @return string sort string
     */
    protected static function tweak_sort_by_id($sort) {
        if (empty($sort)) {
            // Mysql does this - unlikely to be used in real life because $sort is always expected.
            $sort = "id ASC";
        } else if (stripos($sort, 'timecreated') === false) {
            $sort .= ", id ASC";
        } else if (stripos($sort, 'timecreated DESC') !== false) {
            $sort .= ", id DESC";
        } else {
            $sort .= ", id ASC";
        }

        return $sort;
    }
}
