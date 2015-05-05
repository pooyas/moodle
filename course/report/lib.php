<?php

/**
 * This file contains functions used by course reports
 *
 * @package    core
 * @subpackage course
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Return a list of page types
 * @param string $pagetype current page type
 * @param stdClass $parentcontext Block's parent context
 * @param stdClass $currentcontext Current context of block
 */
function coursereport_page_type_list($pagetype, $parentcontext, $currentcontext) {
    $array = array(
        '*' => get_string('page-x', 'pagetype'),
        'course-report-*' => get_string('page-course-report-x', 'pagetype')
    );
    return $array;
}
