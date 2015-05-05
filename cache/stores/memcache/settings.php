<?php

/**
 * The settings for the memcache store.
 *
 * This file is part of the memcache cache store, it contains the API for interacting with an instance of the store.
 *
 * @package    cachestore
 * @subpackage memcache
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

$settings->add(new admin_setting_configtextarea(
        'cachestore_memcache/testservers',
        new lang_string('testservers', 'cachestore_memcache'),
        new lang_string('testservers_desc', 'cachestore_memcache'),
        '', PARAM_RAW, 60, 3));
