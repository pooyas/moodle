<?php

/**
 * Unit tests for the custom file types.
 *
 * @package    tool
 * @subpackage filetypes
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

use tool_filetypes\utils;

/**
 * Unit tests for the custom file types.
 *
 */
class tool_filetypes_test extends advanced_testcase {
    /**
     * Tests is_extension_invalid() function.
     */
    public function test_is_extension_invalid() {
        // The pdf file extension already exists in default lion minetypes.
        $this->assertTrue(utils::is_extension_invalid('pdf'));

        // The frog extension does not.
        $this->assertFalse(utils::is_extension_invalid('frog'));

        // However you could use the pdf extension when editing the pdf extension.
        $this->assertFalse(utils::is_extension_invalid('pdf', 'pdf'));

        // Blank extension is invalid.
        $this->assertTrue(utils::is_extension_invalid(''));

        // Extensions with dot are invalid.
        $this->assertTrue(utils::is_extension_invalid('.frog'));
    }

    /**
     * Tests is_defaulticon_allowed() function.
     */
    public function test_is_defaulticon_allowed() {
        // You ARE allowed to set a default icon for a MIME type that hasn't
        // been used yet.
        $this->assertTrue(utils::is_defaulticon_allowed('application/x-frog'));

        // You AREN'T allowed to set default icon for text/plain as there is
        // already a type that has that set.
        $this->assertFalse(utils::is_defaulticon_allowed('text/plain'));

        // But you ARE still allowed to set it when actually editing txt, which
        // is the default.
        $this->assertTrue(utils::is_defaulticon_allowed('text/plain', 'txt'));
    }

    /**
     * Tests get_icons_from_path() function.
     */
    public function test_get_icons_from_path() {
        // Get icons from the fixtures folder.
        $icons = utils::get_icons_from_path(__DIR__ . '/fixtures');

        // The icons are returned alphabetically and with keys === values.
        // For the icon with numbers after the name, only the base name is
        // returned and only one of it.
        $this->assertEquals(array('frog' => 'frog', 'zombie' => 'zombie'), $icons);
    }
}
