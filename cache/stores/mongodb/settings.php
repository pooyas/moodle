<?php


/**
 * The settings for the mongodb store.
 *
 * This file is part of the mongodb cache store, it contains the API for interacting with an instance of the store.
 *
 * @package    cache_stores
 * @subpackage mongodb
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

$settings->add(new admin_setting_configtextarea(
        'cachestore_mongodb/testserver',
        new lang_string('testserver', 'cachestore_mongodb'),
        new lang_string('testserver_desc', 'cachestore_mongodb'),
        '', PARAM_RAW, 60, 3));