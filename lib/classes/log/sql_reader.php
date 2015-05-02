<?php

/**
 * Log iterator reader interface.
 *
 * @package    core
 * @copyright  2015 David Monllao
 * 
 */

namespace core\log;

defined('LION_INTERNAL') || die();

/**
 * Log iterator reader interface.
 *
 * Replaces sql_select_reader adding functions
 * to return iterators.
 *
 * @since      Lion 2.9
 * @package    core
 * @copyright  2015 David Monllao
 * 
 */
interface sql_reader extends reader {

    /**
     * Fetch records using given criteria.
     *
     * @param string $selectwhere
     * @param array $params
     * @param string $sort
     * @param int $limitfrom
     * @param int $limitnum
     * @return \core\event\base[]
     */
    public function get_events_select($selectwhere, array $params, $sort, $limitfrom, $limitnum);

    /**
     * Return number of events matching given criteria.
     *
     * @param string $selectwhere
     * @param array $params
     * @return int
     */
    public function get_events_select_count($selectwhere, array $params);

    /**
     * Fetch records using the given criteria returning an traversable list of events.
     *
     * Note that the returned object is Traversable, not Iterator, as we are returning
     * EmptyIterator if we know there are no events, and EmptyIterator does not implement
     * Countable {@link https://bugs.php.net/bug.php?id=60577} so valid() should be checked
     * in any case instead of a count().
     *
     * Also note that the traversable object contains a recordset and it is very important
     * that you close it after using it.
     *
     * @param string $selectwhere
     * @param array $params
     * @param string $sort
     * @param int $limitfrom
     * @param int $limitnum
     * @return \Traversable|\core\event\base[] Returns an iterator containing \core\event\base objects.
     */
    public function get_events_select_iterator($selectwhere, array $params, $sort, $limitfrom, $limitnum);

    /**
     * Returns an event from the log data.
     *
     * @param stdClass $data Log data
     * @return \core\event\base
     */
    public function get_log_event($data);
}
