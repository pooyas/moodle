<?php

/**
 * Behat editpdf-related steps definitions.
 *
 * @package    assignfeedback_editpdf
 * @category   test
 * @copyright  2013 Jerome Mouneyrac
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given;

/**
 * Steps definitions related with the editpdf.
 *
 * @package    assignfeedback_editpdf
 * @category   test
 * @copyright  2013 Jerome Mouneyrac
 * 
 */
class behat_assignfeedback_editpdf extends behat_base {

    /**
     * Checks that Ghostscript is installed.
     *
     * @Given /^ghostscript is installed$/
     */
    public function ghostscript_is_installed() {
        $testpath = assignfeedback_editpdf\pdf::test_gs_path();
        if (!extension_loaded('zlib') or
            $testpath->status !== assignfeedback_editpdf\pdf::GSPATH_OK) {
            throw new \Lion\BehatExtension\Exception\SkippedException;
        }
    }
}
