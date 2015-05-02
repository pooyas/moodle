<?php

/**
 * Course module instances list_viewed event.
 *
 * This class has been deprecated, please use \core\event\course_module_instance_list_viewed.
 *
 * @package    core
 * @copyright  2013 Frédéric Massart
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * This class has been deprecated, please use \core\event\course_module_instance_list_viewed.
 *
 * @deprecated Since Lion 2.7
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Frédéric Massart
 * 
 */
abstract class course_module_instances_list_viewed extends course_module_instance_list_viewed {
}

debugging('core\\event\\course_module_instances_list_viewed has been deperecated. Please use
        core\\event\\course_module_instance_list_viewed instead', DEBUG_DEVELOPER);
