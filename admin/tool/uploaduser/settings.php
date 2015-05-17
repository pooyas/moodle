<?php


/**
 * Link to CSV user upload
 *
 * @package    admin_tool
 * @subpackage uploaduser
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

$ADMIN->add('accounts', new admin_externalpage('tooluploaduser', get_string('uploadusers', 'tool_uploaduser'), "$CFG->wwwroot/$CFG->admin/tool/uploaduser/index.php", 'lion/site:uploadusers'));
$ADMIN->add('accounts', new admin_externalpage('tooluploaduserpictures', get_string('uploadpictures','tool_uploaduser'), "$CFG->wwwroot/$CFG->admin/tool/uploaduser/picture.php", 'tool/uploaduser:uploaduserpictures'));
