<?php


/**
 * This file contains functions used by the admin pages
 *
 * @package    core
 * @subpackage admin
 * @copyright  2015 Pooya Saeedi
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
