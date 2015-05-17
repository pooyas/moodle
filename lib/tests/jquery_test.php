<?php


/**
 * Test jQuery integration.
 *
 * @category   phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();


/**
 * This is not a complete jquery test, it just validates
 * Lion integration is set up properly.
 *
 * Launch http://127.0.0.1/lib/tests/other/jquerypage.php to
 * verify it actually works in browser.
 *
 * @category   phpunit
 */
class core_jquery_testcase extends basic_testcase {

    public function test_plugins_file() {
        global $CFG;

        $plugins = null;
        require($CFG->libdir . '/jquery/plugins.php');
        $this->assertInternalType('array', $plugins);
        $this->assertEquals(array('jquery', 'migrate', 'ui', 'ui-css'), array_keys($plugins));

        foreach ($plugins as $type => $files) {
            foreach ($files['files'] as $file) {
                $this->assertFileExists($CFG->libdir . '/jquery/' . $file);
            }
        }
    }
}
