<?php


/**
 * Log storage manager interface.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\log;

defined('LION_INTERNAL') || die();

/**
 * Interface describing log readers.
 *
 * This is intended for reports, use get_log_manager() to get
 * the configured instance.
 *
 */
interface manager {
    /**
     * Return list of available log readers.
     *
     * @param string $interface All returned readers must implement this interface.
     *
     * @return \core\log\reader[]
     */
    public function get_readers($interface = null);

    /**
     * Dispose all initialised stores.
     * @return void
     */
    public function dispose();

    /**
     * For a given report, returns a list of log stores that are supported.
     *
     * @param string $component component.
     *
     * @return false|array list of logstores that support the given report. It returns false if the given $component doesn't
     *      require logstores.
     */
    public function get_supported_logstores($component);
}
