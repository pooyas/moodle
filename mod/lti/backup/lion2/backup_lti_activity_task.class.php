<?php
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
 * Defines backup_lti_activity_task class
 *
 * @package     mod_lti
 * @category    backup
 * @copyright   2009 Marc Alier <marc.alier@upc.edu>, Jordi Piguillem, Nikolas Galanis
 * @copyright   2009 Universitat Politecnica de Catalunya http://www.upc.edu
 * @author      Marc Alier
 * @author      Jordi Piguillem
 * @author      Nikolas Galanis
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/lti/backup/lion2/backup_lti_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the LTI instance
 */
class backup_lti_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the lti.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_lti_activity_structure_step('lti_structure', 'lti.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, "/");

        // Link to the list of basiclti tools.
        $search = "/(".$base."\/mod\/lti\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@LTIINDEX*$2@$', $content);

        // Link to basiclti view by moduleid.
        $search = "/(".$base."\/mod\/lti\/view.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@LTIVIEWBYID*$2@$', $content);

        return $content;
    }
}
