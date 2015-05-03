<?php

/**
 * Log storage reader interface.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\log;

defined('LION_INTERNAL') || die();

/**
 * Sql select reader.
 *
 * @deprecated since Lion 2.9 MDL-48595 - please do not use this interface any more.
 * @see        sql_reader
 * @todo       MDL-49291 This will be deleted in Lion 3.1.
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
interface sql_select_reader extends reader {
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
}
