<?php

/**
 * Provides Common Cartridge v1 converter class
 *
 * @package    core
 * @subpackage backup-convert
 * @copyright  2011 Darko Miletic <dmiletic@lionrooms.com>
 * 
 */

require_once($CFG->dirroot.'/backup/converter/convertlib.php');
require_once($CFG->dirroot.'/backup/cc/includes/constants.php');
require_once($CFG->dirroot.'/backup/cc/cc2lion.php');
require_once($CFG->dirroot.'/backup/cc/validator.php');

class imscc1_converter extends base_converter {

    /**
     * Log a message
     *
     * @see parent::log()
     * @param string $message message text
     * @param int $level message level {@example backup::LOG_WARNING}
     * @param null|mixed $a additional information
     * @param null|int $depth the message depth
     * @param bool $display whether the message should be sent to the output, too
     */
    public function log($message, $level, $a = null, $depth = null, $display = false) {
        parent::log('(imscc1) '.$message, $level, $a, $depth, $display);
    }

    /**
     * Detects the Common Cartridge 1.0 format of the backup directory
     *
     * @param string $tempdir the name of the backup directory
     * @return null|string backup::FORMAT_IMSCC1 if the Common Cartridge 1.0 is detected, null otherwise
     */
    public static function detect_format($tempdir) {
        global $CFG;

        $filepath = $CFG->dataroot . '/temp/backup/' . $tempdir;
        $manifest = cc2lion::get_manifest($filepath);
        if (!empty($manifest)) {
            // Looks promising, lets load some information.
            $handle = fopen($manifest, 'r');
            $xml_snippet = fread($handle, 1024);
            fclose($handle);

            // Check if it has the required strings.

            $xml_snippet = strtolower($xml_snippet);
            $xml_snippet = preg_replace('/\s*/m', '', $xml_snippet);
            $xml_snippet = str_replace("'", '', $xml_snippet);
            $xml_snippet = str_replace('"', '', $xml_snippet);

            $search_string = "xmlns=http://www.imsglobal.org/xsd/imscc/imscp_v1p1";
            if (strpos($xml_snippet, $search_string) !== false) {
                return backup::FORMAT_IMSCC1;
            }
        }

        return null;
    }


    /**
     * Returns the basic information about the converter
     *
     * The returned array must contain the following keys:
     * 'from' - the supported source format, eg. backup::FORMAT_LION1
     * 'to'   - the supported target format, eg. backup::FORMAT_LION
     * 'cost' - the cost of the conversion, non-negative non-zero integer
     */
    public static function description() {

        return array(
                'from'  => backup::FORMAT_IMSCC1,
                'to'    => backup::FORMAT_LION1,
                'cost'  => 10
        );
    }

    protected function execute() {
        global $CFG;

        $manifest = cc2lion::get_manifest($this->get_tempdir_path());
        if (empty($manifest)) {
            throw new imscc1_convert_exception('No Manifest detected!');
        }

        $this->log('validating manifest', backup::LOG_DEBUG, null, 1);
        $validator = new manifest10_validator($CFG->dirroot . '/backup/cc/schemas');
        if (!$validator->validate($manifest)) {
            $this->log('validation error(s): '.PHP_EOL.error_messages::instance(), backup::LOG_DEBUG, null, 2);
            throw new imscc1_convert_exception(error_messages::instance()->to_string(true));
        }

        $manifestdir = dirname($manifest);
        $cc2lion = new cc2lion($manifest);
        if ($cc2lion->is_auth()) {
            throw new imscc1_convert_exception('protected_cc_not_supported');
        }
        $status = $cc2lion->generate_lion_xml();
        // Final cleanup.
        $xml_error = new libxml_errors_mgr(true);
        $mdoc = new DOMDocument();
        $mdoc->preserveWhiteSpace = false;
        $mdoc->formatOutput = true;
        $mdoc->validateOnParse = false;
        $mdoc->strictErrorChecking = false;
        if ($mdoc->load($manifestdir.'/lion.xml', LIBXML_NONET)) {
            $mdoc->save($this->get_workdir_path().'/lion.xml', LIBXML_NOEMPTYTAG);
        } else {
            $xml_error->collect();
            $this->log('validation error(s): '.PHP_EOL.error_messages::instance(), backup::LOG_DEBUG, null, 2);
            throw new imscc1_convert_exception(error_messages::instance()->to_string(true));
        }
        // Move the files to the workdir.
        rename($manifestdir.'/course_files', $this->get_workdir_path().'/course_files');
    }


}

/**
 * Exception thrown by this converter
 */
class imscc1_convert_exception extends convert_exception {
}
