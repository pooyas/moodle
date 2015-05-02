<?php

/**
 * Definition of assignment event handlers
 *
 * @package mod_assignment
 * @category event
 * @copyright 1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$handlers = array();

/* List of events thrown from assignment module

assignment_finalize_sent - object course, object user, object cm, object assignment, fileareaname
assignment_file_sent     - object course, object user, object cm, object assignment, object file

*/