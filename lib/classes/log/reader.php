<?php


/**
 * Log storage reader interface.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\log;

defined('LION_INTERNAL') || die();

interface reader {
    /**
     * Localised name of the reader.
     *
     * To be used in selection for in reports.
     *
     * @return string
     */
    public function get_name();

    /**
     * Longer description of the log data source.
     * @return string
     */
    public function get_description();

    /**
     * Are the new events appearing in the reader?
     *
     * @return bool true means new log events are being added, false means no new data will be added
     */
    public function is_logging();
}
