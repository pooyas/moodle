<?php

/**
 * This file contains form for bulk changing user enrolments.
 *
 * @package    enrol_manual
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

require_once("$CFG->dirroot/enrol/bulkchange_forms.php");

/**
 * The form to collect required information when bulk editing users enrolments.
 *
 * @copyright 2015 Pooya Saeedi
 * 
 */
class enrol_manual_editselectedusers_form extends enrol_bulk_enrolment_change_form {}

/**
 * The form to confirm the intention to bulk delete users enrolments.
 *
 * @copyright 2015 Pooya Saeedi
 * 
 */
class enrol_manual_deleteselectedusers_form extends enrol_bulk_enrolment_confirm_form {}
