<?php

/**
 * lock unit tests
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();


/**
 * Unit tests for our locking configuration.
 *
 */
class lock_config_testcase extends advanced_testcase {

    /**
     * Tests the static parse charset method
     * @return void
     */
    public function test_lock_config() {
        global $CFG;
        $original = null;
        if (isset($CFG->lock_factory)) {
            $original = $CFG->lock_factory;
        }

        // Test no configuration.
        unset($CFG->lock_factory);

        $factory = \core\lock\lock_config::get_lock_factory('cache');

        $this->assertNotEmpty($factory, 'Get a default factory with no configuration');

        $CFG->lock_factory = '\core\lock\file_lock_factory';

        $factory = \core\lock\lock_config::get_lock_factory('cache');
        $this->assertTrue($factory instanceof \core\lock\file_lock_factory,
                          'Get a default factory with a set configuration');

        $CFG->lock_factory = '\core\lock\db_record_lock_factory';

        $factory = \core\lock\lock_config::get_lock_factory('cache');
        $this->assertTrue($factory instanceof \core\lock\db_record_lock_factory,
                          'Get a default factory with a changed configuration');

        if ($original) {
            $CFG->lock_factory = $original;
        } else {
            unset($CFG->lock_factory);
        }
    }
}

