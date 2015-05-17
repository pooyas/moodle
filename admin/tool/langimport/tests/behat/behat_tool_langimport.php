<?php


/**
 * Behat steps definitions for Language import tool
 *
 * @category  test
 * @package    admin_tool
 * @subpackage langimport
 * @copyright  2015 Pooya Saeedi
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../../lib/behat/behat_base.php');

use Lion\BehatExtension\Exception\SkippedException;

/**
 * Steps definitions related with the Language import tool
 *
 * @category  test
 */
class behat_tool_langimport extends behat_base {

    /**
     * This step looks to see if the remote language import tests should be run (indicated by
     * setting TOOL_LANGIMPORT_REMOTE_TESTS in config.php.
     *
     * @Given /^remote langimport tests are enabled$/
     */
    public function remote_langimport_tests_are_enabled() {
        if (!defined('TOOL_LANGIMPORT_REMOTE_TESTS')) {
            throw new SkippedException('To run the remote langimport tests you must '.
                'define TOOL_LANGIMPORT_REMOTE_TESTS in config.php');
        }
    }

    /**
     * Downloads a langpack and fakes it being outdated
     *
     * @param string $langcode The language code (e.g. en)
     * @Given /^outdated langpack \'([^\']*)\' is installed$/
     */
    public function outdated_langpack_is_installed($langcode) {
        global $CFG;
        require_once($CFG->libdir.'/componentlib.class.php');

        // Download the langpack.
        $dir = make_upload_directory('lang');
        $installer = new lang_installer($langcode);
        $result = $installer->run();

        if ($result[$langcode] !== lang_installer::RESULT_INSTALLED) {
            throw new coding_exception("Failed to install langpack '$langcode'");
        }

        $path = "$dir/$langcode/$langcode.md5";

        if (!file_exists($path)) {
            throw new coding_exception("Failed to find '$langcode' checksum");
        }
        file_put_contents($path, '000000');
    }
}
