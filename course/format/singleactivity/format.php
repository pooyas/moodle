<?php

/**
 * format.php - course format featuring single activity included from view.php
 *
 * if we are not redirected before this point this means we want to
 * either manage orphaned activities - i.e. display section 1,
 * or the activity is not setup, does not have url or is not accessible at the
 * moment
 *
 * @package    format_singleactivity
 * @copyright  2012 Marina Glancy
 * 
 */

$courserenderer = $PAGE->get_renderer('format_singleactivity');
echo $courserenderer->display($course, $section != 0);
