<?php

/**
 * Library code used by the roles administration interfaces.
 *
 * @package    core_role
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Get the potential assignees selector for a given context.
 *
 * If this context is a course context, or inside a course context (module or
 * some blocks) then return a core_role_potential_assignees_below_course object. Otherwise
 * return a core_role_potential_assignees_course_and_above.
 *
 * @param context $context a context.
 * @param string $name passed to user selector constructor.
 * @param array $options to user selector constructor.
 * @return user_selector_base an appropriate user selector.
 */
function core_role_get_potential_user_selector(context $context, $name, $options) {
    $blockinsidecourse = false;
    if ($context->contextlevel == CONTEXT_BLOCK) {
        $parentcontext = $context->get_parent_context();
        $blockinsidecourse = in_array($parentcontext->contextlevel, array(CONTEXT_MODULE, CONTEXT_COURSE));
    }

    if (($context->contextlevel == CONTEXT_MODULE || $blockinsidecourse) &&
            !is_inside_frontpage($context)) {
        $potentialuserselector = new core_role_potential_assignees_below_course('addselect', $options);
    } else {
        $potentialuserselector = new core_role_potential_assignees_course_and_above('addselect', $options);
    }

    return $potentialuserselector;
}
