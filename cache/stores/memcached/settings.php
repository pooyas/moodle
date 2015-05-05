<?php

/**
 * The settings for the memcached store.
 *
 * This file is part of the memcached cache store, it contains the API for interacting with an instance of the store.
 *
 * @package    cachestore
 * @subpackage memcached
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

$settings->add(new admin_setting_configtextarea(
        'cachestore_memcached/testservers',
        new lang_string('testservers', 'cachestore_memcached'),
        new lang_string('testservers_desc', 'cachestore_memcached'),
        '', PARAM_RAW, 60, 3));
