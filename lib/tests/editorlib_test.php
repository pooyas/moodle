<?php

/**
 * Tests editors subsystem.
 *
 * @package    core_editors
 * @subpackage phpunit
 * @copyright  2013 onwards Martin Dougiamas (http://dougiamas.com)
 * @author     Damyon Wiese
 * 
 */

defined('LION_INTERNAL') || die();


class core_editorslib_testcase extends advanced_testcase {

    /**
     * Tests the installation of event handlers from file
     */
    public function test_get_preferred_editor() {

        // Fake a user agent.
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_5; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.21     5 Safari/534.10';

        $enabled = editors_get_enabled();
        // Array assignment is always a clone.
        $editors = $enabled;

        $first = array_shift($enabled);

        // Get the default editor which should be the first in the list.
        set_user_preference('htmleditor', '');
        $preferred = editors_get_preferred_editor();
        $this->assertEquals($first, $preferred);

        foreach ($editors as $key => $editor) {
            // User has set a preference for a specific editor.
            set_user_preference('htmleditor', $key);
            $preferred = editors_get_preferred_editor();
            $this->assertEquals($editor, $preferred);
        }
    }

}

