<?php

/**
 * @package    backup
 * @subpackage cc
 * @copyright  2015 Pooya Saeedi
 */
defined('LION_INTERNAL') or die('Direct access to this script is forbidden.');

require_once($CFG->dirroot . '/backup/cc/includes/constants.php');
require_once($CFG->dirroot . '/backup/cc/cc2lion.php');

function cc_convert ($dir) {

    $manifest_file = $dir . DIRECTORY_SEPARATOR . 'imsmanifest.xml';
    $lion_file = $dir . DIRECTORY_SEPARATOR . 'lion.xml';
    $schema_file = 'cc' . DIRECTORY_SEPARATOR . '' . DIRECTORY_SEPARATOR . 'schemas' . DIRECTORY_SEPARATOR . 'cclibxml2validator.xsd';

    if (is_readable($manifest_file) && !is_readable($lion_file)) {

        $is_cc = detect_cc_format($manifest_file);

        if ($is_cc) {

            $detected_requirements = detect_requirements();

            if (!$detected_requirements["php5"]) {
                notify(get_string('cc_import_req_php5', 'imscc'));
                return false;
            }

            if (!$detected_requirements["dom"]) {
                notify(get_string('cc_import_req_dom', 'imscc'));
                return false;
            }

            if (!$detected_requirements["libxml"]) {
                notify(get_string('cc_import_req_libxml', 'imscc'));
                return false;
            }

            if (!$detected_requirements["libxmlminversion"]) {
                notify(get_string('cc_import_req_libxmlminversion', 'imscc'));
                return false;
            }
            if (!$detected_requirements["xsl"]) {
                notify(get_string('cc_import_req_xsl', 'imscc'));
                return false;
            }

            echo get_string('cc2lion_checking_schema', 'imscc') . '<br />';

            $cc_manifest = new DOMDocument();

            if ($cc_manifest->load($manifest_file)) {
                if ($cc_manifest->schemaValidate($schema_file)) {

                    echo get_string('cc2lion_valid_schema', 'imscc') . '<br />';

                    $cc2lion = new cc2lion($manifest_file);

                    if (!$cc2lion->is_auth()) {
                        return $cc2lion->generate_lion_xml();
                    } else {
                        notify(get_string('cc2lion_req_auth', 'imscc'));
                        return false;
                    }

                } else {
                    notify(get_string('cc2lion_invalid_schema', 'imscc'));
                    return false;
                }

            } else {
                notify(get_string('cc2lion_manifest_dont_load', 'imscc'));
                return false;
            }
        }
    }

    return true;
}

function detect_requirements () {

    if (floor(phpversion()) >= 5) {
        $detected["php5"] = true;
    } else {
        $detected["php5"] = false;
    }

    $detected["xsl"] = extension_loaded('xsl');
    $detected['dom'] = extension_loaded('dom');
    $detected['libxml'] = extension_loaded('libxml');
    $detected['libxmlminversion'] = extension_loaded('libxml') && version_compare(LIBXML_DOTTED_VERSION, '2.6.30', '>=');

    return $detected;

}

function detect_cc_format ($xml_file) {

    $inpos = 0;
    $xml_snippet = file_get_contents($xml_file, 0, NULL, 0, 500);

    if (!empty($xml_snippet)) {

        $xml_snippet = strtolower($xml_snippet);
        $xml_snippet = preg_replace('/\s*/m', '', $xml_snippet);
        $xml_snippet = str_replace("'", '', $xml_snippet);
        $xml_snippet = str_replace('"', '', $xml_snippet);

        $search_string = "xmlns=" . NS_COMMON_CARTRIDGE;

        $inpos = strpos($xml_snippet, $search_string);

        if ($inpos) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }

}
