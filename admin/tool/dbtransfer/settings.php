<?php

/**
 * Add hidden links db transfer tool
 *
 * @package    tool_dbtransfer
 * @copyright  2011 Petr Skoda {@link http://skodak.org/}
 * 
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('experimental', new admin_externalpage('tooldbtransfer', get_string('dbtransfer', 'tool_dbtransfer'),
        $CFG->wwwroot.'/'.$CFG->admin.'/tool/dbtransfer/index.php', 'lion/site:config', false));
    // DB export/import is not ready yet - keep it hidden for now.
    $ADMIN->add('experimental', new admin_externalpage('tooldbexport', get_string('dbexport', 'tool_dbtransfer'),
        $CFG->wwwroot.'/'.$CFG->admin.'/tool/dbtransfer/dbexport.php', 'lion/site:config', true));
}
