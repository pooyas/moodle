<?php

/**
 * Fixtures for legacy logging testing.
 *
 * @package    logstore_legacy
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */

namespace logstore_legacy\test;

defined('LION_INTERNAL') || die();

class unittest_logstore_legacy extends \logstore_legacy\log\store {

    /**
     * Wrapper to make protected method accessible during testing.
     *
     * @param string $select sql predicate.
     * @param array $params sql params.
     * @param string $sort sort options.
     *
     * @return array returns array of sql predicate, params and sorting criteria.
     */
    public static function replace_sql_legacy($select, array $params, $sort = '') {
        return parent::replace_sql_legacy($select, $params, $sort);
    }
}
