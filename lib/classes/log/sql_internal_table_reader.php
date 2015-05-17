<?php


/**
 * Log storage sql internal table reader interface.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\log;

defined('LION_INTERNAL') || die();

/**
 * Sql internal table reader.
 *
 * Replaces sql_internal_reader and extends sql_reader.
 *
 */
interface sql_internal_table_reader extends sql_reader {

    /**
     * Returns name of the table or database view that
     * holds the log data in standardised format.
     *
     * Note: this table must be used for reading only,
     * it is strongly recommended to use this in complex reports only.
     *
     * @return string
     */
    public function get_internal_log_table_name();
}
