<?php

/**
 * Definition of assignment event handlers
 *
 * @package mod_assignment
 * @category event
 * @copyright 2015 Pooya Saeedi
 * 
 */

$handlers = array();

/* List of events thrown from assignment module

assignment_finalize_sent - object course, object user, object cm, object assignment, fileareaname
assignment_file_sent     - object course, object user, object cm, object assignment, object file

*/