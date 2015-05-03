<?php

/**
 * Functions used by the health tool.
 *
 * @package    tool
 * @subpackage health
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Given a list of categories, this function searches for ones
 * that have a missing parent category.
 *
 * @param array $categories List of categories.
 * @return array List of categories with missing parents.
 */
function tool_health_category_find_missing_parents($categories) {
    $missingparent = array();

    foreach ($categories as $category) {
        if ($category->parent != 0 && !array_key_exists($category->parent, $categories)) {
            $missingparent[$category->id] = $category;
        }
    }

    return $missingparent;
}

/**
 * Generates a list of categories with missing parents.
 *
 * @param array $missingparent List of categories with missing parents.
 * @return string Bullet point list of categories with missing parents.
 */
function tool_health_category_list_missing_parents($missingparent) {
    $description = '';

    if (!empty($missingparent)) {
        $description .= '<p>The following categories are missing their parents:</p><ul>';
        foreach ($missingparent as $cat) {
            $description .= "<li>Category $cat->id: " . s($cat->name) . "</li>\n";
        }
        $description .= "</ul>\n";
    }

    return $description;
}

/**
 * Given a list of categories, this function searches for ones
 * that have loops to previous parent categories.
 *
 * @param array $categories List of categories.
 * @return array List of categories with loops.
 */
function tool_health_category_find_loops($categories) {
    $loops = array();

    while (!empty($categories)) {

        $current = array_pop($categories);
        $thisloop = array($current->id => $current);

        while (true) {
            if (isset($thisloop[$current->parent])) {
                // Loop detected.
                $loops = $loops + $thisloop;
                break;
            } else if ($current->parent === 0) {
                // Top level.
                break;
            } else if (isset($loops[$current->parent])) {
                // If the parent is in a loop we should also update this category.
                $loops = $loops + $thisloop;
                break;
            } else if (!isset($categories[$current->parent])) {
                // We already checked this category and is correct.
                break;
            } else {
                // Continue following the path.
                $current = $categories[$current->parent];
                $thisloop[$current->id] = $current;
                unset($categories[$current->id]);
            }
        }
    }

    return $loops;
}

/**
 * Generates a list of categories with loops.
 *
 * @param array $loops List of categories with loops.
 * @return string Bullet point list of categories with loops.
 */
function tool_health_category_list_loops($loops) {
    $description = '';

    if (!empty($loops)) {
        $description .= '<p>The following categories form a loop of parents:</p><ul>';
        foreach ($loops as $loop) {
            $description .= "<li>\n";
            $description .= "Category $loop->id: " . s($loop->name) . " has parent $loop->parent\n";
            $description .= "</li>\n";
        }
        $description .= "</ul>\n";
    }

    return $description;
}
