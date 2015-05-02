<?php

/**
 * Log storage sql reader interface.
 *
 * @package    core
 * @copyright  2014 Petr Skoda
 * 
 */

namespace core\log;

defined('LION_INTERNAL') || die();

/**
 * Sql internal reader.
 *
 * @deprecated since Lion 2.9 MDL-48595 - please do not use this interface any more.
 * @see        sql_reader
 * @todo       MDL-49291 This will be deleted in Lion 3.1.
 * @package    core
 * @copyright  2013 Petr Skoda {@link http://skodak.org}
 * 
 */
interface sql_internal_reader extends sql_select_reader {

    /**
     * Returns name of the table or database view that holds the log data in standardised format.
     *
     * Note: this table must be used for reading only,
     * it is strongly recommended to use this in complex reports only.
     *
     * @return string
     */
    public function get_internal_log_table_name();
}
