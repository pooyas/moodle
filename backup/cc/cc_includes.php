<?php

/**
 * Main include for IMS Common Cartridge export classes
 *
 * @package    backup-convert
 * @copyright  2011 Darko Miletic <dmiletic@lionrooms.com>
 * 
 */

require_once($CFG->dirroot .'/backup/cc/cc_lib/xmlbase.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_resources.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_builder_creator.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_manifest.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_metadata.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_metadata_resource.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_metadata_file.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_version11.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/gral_lib/pathutils.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/gral_lib/functions.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_organization.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_converter_basiclti.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_converter_lti.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_converter_forum.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_converter_url.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_converter_resource.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_converter_quiz.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_converter_page.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_converter_label.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_converter_folder.php');
require_once($CFG->dirroot .'/backup/cc/cc_lib/cc_convert_lion2.php');
