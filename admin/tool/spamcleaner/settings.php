<?php

/**
 * Link to spamcleaner.
 *
 * For now keep in Reports folder, we should move it elsewhere once we deal with contexts in general reports and navigation
 *
 * @package    tool
 * @subpackage unsuproles
 * @copyright  2011 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('reports', new admin_externalpage('toolspamcleaner', get_string('pluginname', 'tool_spamcleaner'), "$CFG->wwwroot/$CFG->admin/tool/spamcleaner/index.php", 'lion/site:config'));
}

