<?php

/**
 * Unit tests for localization support in lib/lionlib.php
 *
 * @package     core
 * @category    phpunit
 * @copyright   2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir.'/lionlib.php');

/**
 * Tests for the API of the string_manager.
 *
 * @copyright 2015 Pooya Saeedi
 * 
 */
class core_string_manager_standard_testcase extends advanced_testcase {

    public function test_string_manager_instance() {
        $this->resetAfterTest();

        $otherroot = dirname(__FILE__).'/fixtures/langtest';
        $stringman = testable_core_string_manager::instance($otherroot);
        $this->assertInstanceOf('core_string_manager', $stringman);
    }

    public function test_get_language_dependencies() {
        $this->resetAfterTest();

        $otherroot = dirname(__FILE__).'/fixtures/langtest';
        $stringman = testable_core_string_manager::instance($otherroot);

        // There is no parent language for 'en'.
        $this->assertSame(array(), $stringman->get_language_dependencies('en'));
        // Language with no parent language declared.
        $this->assertSame(array('aa'), $stringman->get_language_dependencies('aa'));
        // Language with parent language explicitly set to English (en < de).
        $this->assertSame(array('de'), $stringman->get_language_dependencies('de'));
        // Language dependency hierarchy (de < de_du < de_kids).
        $this->assertSame(array('de', 'de_du', 'de_kids'), $stringman->get_language_dependencies('de_kids'));
        // Language with the parent language misconfigured to itself (sd < sd).
        $this->assertSame(array('sd'), $stringman->get_language_dependencies('sd'));
        // Language with circular dependency (cda < cdb < cdc < cda).
        $this->assertSame(array('cda', 'cdb', 'cdc'), $stringman->get_language_dependencies('cdc'));
        // Orphaned language (N/A < bb).
        $this->assertSame(array('bb'), $stringman->get_language_dependencies('bb'));
        // Descendant of an orphaned language (N/A < bb < bc).
        $this->assertSame(array('bb', 'bc'), $stringman->get_language_dependencies('bc'));
    }

    public function test_deprecated_strings() {
        $stringman = get_string_manager();

        // Check non-deprecated string.
        $this->assertFalse($stringman->string_deprecated('hidden', 'grades'));

        // Check deprecated string.
        $this->assertTrue($stringman->string_deprecated('hidden', 'repository'));
        $this->assertTrue($stringman->string_exists('hidden', 'repository'));
        $this->assertDebuggingNotCalled();
        $this->assertEquals('Hidden', get_string('hidden', 'repository'));
        $this->assertDebuggingCalled('String [hidden,core_repository] is deprecated. '.
            'Either you should no longer be using that string, or the string has been incorrectly deprecated, in which case you should report this as a bug. '.
            'Please refer to https://docs.lion.org/dev/String_deprecation');
    }

    /**
     * This test is a built-in validation of deprecated.txt files in lang locations.
     *
     * It will fail if the string in the wrong format or non-existing (mistyped) string was deprecated.
     */
    public function test_validate_deprecated_strings_files() {
        global $CFG;
        $stringman = get_string_manager();
        $teststringman = testable_core_string_manager::instance($CFG->langotherroot, $CFG->langlocalroot, array());
        $allstrings = $teststringman->get_all_deprecated_strings();

        foreach ($allstrings as $string) {
            if (!preg_match('/^(.*),(.*)$/', $string, $matches) ||
                clean_param($matches[2], PARAM_COMPONENT) !== $matches[2]) {
                $this->fail('String "'.$string.'" appearing in one of the lang/en/deprecated.txt files does not have correct syntax');
            }
            list($pluginttype, $pluginname) = core_component::normalize_component($matches[2]);
            if ($matches[2] !== $pluginttype . '_' . $pluginname) {
                $this->fail('String "'.$string.'" appearing in one of the lang/en/deprecated.txt files does not have normalised component name');
            }
            if (!$stringman->string_exists($matches[1], $matches[2])) {
                $this->fail('String "'.$string.'" appearing in one of the lang/en/deprecated.txt files does not exist');
            }
        }
    }
}


/**
 * Helper class providing testable string_manager
 *
 * @copyright 2015 Pooya Saeedi
 * 
 */
class testable_core_string_manager extends core_string_manager_standard {

    /**
     * Factory method
     *
     * @param string $otherroot full path to the location of installed upstream language packs
     * @param string $localroot full path to the location of locally customized language packs, defaults to $otherroot
     * @param bool $usecache use application permanent cache
     * @param array $translist explicit list of visible translations
     * @param string $menucache the location of a file that caches the list of available translations
     * @return testable_core_string_manager
     */
    public static function instance($otherroot, $localroot = null, $usecache = false, array $translist = array(), $menucache = null) {
        global $CFG;

        if (is_null($localroot)) {
            $localroot = $otherroot;
        }

        if (is_null($menucache)) {
            $menucache = $CFG->cachedir.'/languages';
        }

        return new testable_core_string_manager($otherroot, $localroot, $usecache, $translist, $menucache);
    }

    public function get_all_deprecated_strings() {
        return array_flip($this->load_deprecated_strings());
    }
}
