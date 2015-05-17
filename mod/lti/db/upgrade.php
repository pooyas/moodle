<?php


/**
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
*/

//
// This file is part of BasicLTI4Lion
//
// BasicLTI4Lion is an IMS BasicLTI (Basic Learning Tools for Interoperability)
// consumer for Lion 1.9 and Lion 2.0. BasicLTI is a IMS Standard that allows web
// based learning tools to be easily integrated in LMS as native ones. The IMS BasicLTI
// specification is part of the IMS standard Common Cartridge 1.1 Sakai and other main LMS
// are already supporting or going to support BasicLTI. This project Implements the consumer
// for Lion. Lion is a Free Open source Learning Management System by Martin Dougiamas.
// BasicLTI4Lion is a project iniciated and leaded by Ludo(Marc Alier) and Jordi Piguillem
// at the GESSI research group at UPC.
// SimpleLTI consumer for Lion is an implementation of the early specification of LTI
// by Charles Severance (Dr Chuck) htp://dr-chuck.com , developed by Jordi Piguillem in a
// Google Summer of Code 2008 project co-mentored by Charles Severance and Marc Alier.
//
// BasicLTI4Lion is copyright 2009 by Marc Alier Forment, Jordi Piguillem and Nikolas Galanis
// of the Universitat Politecnica de Catalunya http://www.upc.edu
// Contact info: Marc Alier Forment granludo @ gmail.com or marc.alier @ upc.edu.

/**
 * This file keeps track of upgrades to the lti module
 *
 *  marc.alier@upc.edu
 */

 defined('LION_INTERNAL') || die;

/**
 * xmldb_lti_upgrade is the function that upgrades
 * the lti module database when is needed
 *
 * This function is automaticly called when version number in
 * version.php changes.
 *
 * @param int $oldversion New old version number.
 *
 * @return boolean
 */
function xmldb_lti_upgrade($oldversion) {
    global $CFG, $DB;

    require_once(__DIR__ . '/upgradelib.php');

    $dbman = $DB->get_manager();

    // Lion v2.2.0 release upgrade line
    // Put any upgrade step following this.

    // Lion v2.3.0 release upgrade line
    // Put any upgrade step following this.

    // Lion v2.4.0 release upgrade line
    // Put any upgrade step following this.

    // Lion v2.5.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2014060201) {

        // Changing type of field grade on table lti to int.
        $table = new xmldb_table('lti');
        $field = new xmldb_field('grade', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '100',
                'instructorchoiceacceptgrades');

        // Launch change of type for field grade.
        $dbman->change_field_type($table, $field);

        // Lti savepoint reached.
        upgrade_mod_savepoint(true, 2014060201, 'lti');
    }

    if ($oldversion < 2014061200) {

        // Define table lti_tool_proxies to be created.
        $table = new xmldb_table('lti_tool_proxies');

        // Adding fields to table lti_tool_proxies.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, 'Tool Provider');
        $table->add_field('regurl', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('state', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('guid', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('secret', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('vendorcode', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('capabilityoffered', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('serviceoffered', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('toolproxy', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('createdby', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table lti_tool_proxies.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table lti_tool_proxies.
        $table->add_index('guid', XMLDB_INDEX_UNIQUE, array('guid'));

        // Conditionally launch create table for lti_tool_proxies.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table lti_tool_settings to be created.
        $table = new xmldb_table('lti_tool_settings');

        // Adding fields to table lti_tool_settings.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('toolproxyid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('course', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('coursemoduleid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('settings', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table lti_tool_settings.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('toolproxy', XMLDB_KEY_FOREIGN, array('toolproxyid'), 'lti_tool_proxies', array('id'));
        $table->add_key('course', XMLDB_KEY_FOREIGN, array('course'), 'course', array('id'));
        $table->add_key('coursemodule', XMLDB_KEY_FOREIGN, array('coursemoduleid'), 'lti', array('id'));

        // Conditionally launch create table for lti_tool_settings.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table lti_types to be updated.
        $table = new xmldb_table('lti_types');

        // Adding fields to table lti_types.
        $field = new xmldb_field('toolproxyid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        $field = new xmldb_field('enabledcapability', XMLDB_TYPE_TEXT, null, null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        $field = new xmldb_field('parameter', XMLDB_TYPE_TEXT, null, null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        $field = new xmldb_field('icon', XMLDB_TYPE_TEXT, null, null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        $field = new xmldb_field('secureicon', XMLDB_TYPE_TEXT, null, null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Lti savepoint reached.
        upgrade_mod_savepoint(true, 2014061200, 'lti');
    }

    if ($oldversion < 2014100300) {

        mod_lti_upgrade_custom_separator();

        // Lti savepoint reached.
        upgrade_mod_savepoint(true, 2014100300, 'lti');
    }

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}

