<?php

/**
 * Helper trait store.
 *
 * @package    tool_log
 * @copyright  2014 onwards Ankit Agarwal
 * 
 */

namespace tool_log\helper;
defined('LION_INTERNAL') || die();

/**
 * Helper trait store. Adds some helper methods for stores.
 *
 * @package    tool_log
 * @copyright  2014 onwards Ankit Agarwal
 * 
 */
trait store {

    /** @var \tool_log\log\manager $manager manager instance. */
    protected $manager;

    /** @var string $component Frankenstyle store name. */
    protected $component;

    /** @var string $store name of the store. */
    protected $store;


    /**
     * Setup store specific variables.
     *
     * @param \tool_log\log\manager $manager manager instance.
     */
    protected function helper_setup(\tool_log\log\manager $manager) {
        $this->manager = $manager;
        $called = get_called_class();
        $parts = explode('\\', $called);
        if (!isset($parts[0]) || strpos($parts[0], 'logstore_') !== 0) {
            throw new \coding_exception("Store $called doesn't define classes in correct namespaces.");
        }
        $this->component = $parts[0];
        $this->store = str_replace('logstore_', '', $this->store);
    }

    /**
     * Api to get plugin config
     *
     * @param string $name name of the config.
     * @param null|mixed $default default value to return.
     *
     * @return mixed|null return config value.
     */
    protected function get_config($name, $default = null) {
        $value = get_config($this->component, $name);
        if ($value !== false) {
            return $value;
        }
        return $default;
    }

}
