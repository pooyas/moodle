<?php


/**
 * This file contains functions used by the admin pages
 *
 * @since Lion 2.1
 * @package admin
 * @copyright 2011 Andrew Davis
 * 
 */

/**
 * Return a list of page types
 * @param string $pagetype current page type
 * @param stdClass $parentcontext Block's parent context
 * @param stdClass $currentcontext Current context of block
 */
function admin_page_type_list($pagetype, $parentcontext, $currentcontext) {
    $array = array(
        'admin-*' => get_string('page-admin-x', 'pagetype'),
        $pagetype => get_string('page-admin-current', 'pagetype')
    );
    return $array;
}
