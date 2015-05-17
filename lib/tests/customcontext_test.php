<?php


/**
 * Code quality unit tests that are fast enough to run each time.
 *
 * @category   phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Bogus custom context class for testing
 */
class context_bogus1 extends context {
    /**
     * Returns the most relevant URL for this context.
     *
     * @return lion_url
     */
    public function get_url() {
        global $ME;
        return $ME;
    }

    /**
     * Returns array of relevant context capability records.
     *
     * @return array
     */
    public function get_capabilities() {
        return array();
    }
}

/**
 * Bogus custom context class for testing
 */
class context_bogus2 extends context {
    /**
     * Returns the most relevant URL for this context.
     *
     * @return lion_url
     */
    public function get_url() {
        global $ME;
        return $ME;
    }

    /**
     * Returns array of relevant context capability records.
     *
     * @return array
     */
    public function get_capabilities() {
        return array();
    }
}

/**
 * Bogus custom context class for testing
 */
class context_bogus3 extends context {
    /**
     * Returns the most relevant URL for this context.
     *
     * @return lion_url
     */
    public function get_url() {
        global $ME;
        return $ME;
    }

    /**
     * Returns array of relevant context capability records.
     *
     * @return array
     */
    public function get_capabilities() {
        return array();
    }
}

class customcontext_testcase extends advanced_testcase {

    /**
     * Perform setup before every test. This tells Lion's phpunit to reset the database after every test.
     */
    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test case for custom context classes
     */
    public function test_customcontexts() {
        global $CFG;
        static $customcontexts = array(
            11 => 'context_bogus1',
            12 => 'context_bogus2',
            13 => 'context_bogus3'
        );

        // save any existing custom contexts
        $existingcustomcontexts = get_config(null, 'custom_context_classes');

        set_config('custom_context_classes', serialize($customcontexts));
        initialise_cfg();
        context_helper::reset_levels();
        $alllevels = context_helper::get_all_levels();
        $this->assertEquals($alllevels[11], 'context_bogus1');
        $this->assertEquals($alllevels[12], 'context_bogus2');
        $this->assertEquals($alllevels[13], 'context_bogus3');

        // clean-up & restore any custom contexts
        set_config('custom_context_classes', ($existingcustomcontexts === false) ? null : $existingcustomcontexts);
        initialise_cfg();
        context_helper::reset_levels();
    }
}
