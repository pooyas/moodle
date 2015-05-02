<?php


/**
 * Library of functions and constants for module label
 *
 * @package mod_label
 * @copyright  2003 onwards Martin Dougiamas  {@link http://lion.com}
 * 
 */

require_once("../../config.php");
require_once("lib.php");

$id = required_param('id',PARAM_INT);   // course

$PAGE->set_url('/mod/label/index.php', array('id'=>$id));

redirect("$CFG->wwwroot/course/view.php?id=$id");


