<?php


/**
 * Course module instances list_viewed event.
 *
 * This class has been deprecated, please use \core\event\course_module_instance_list_viewed.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * This class has been deprecated, please use \core\event\course_module_instance_list_viewed.
 *
 * @deprecated Since Lion 2.7
 */
abstract class course_module_instances_list_viewed extends course_module_instance_list_viewed {
}

debugging('core\\event\\course_module_instances_list_viewed has been deperecated. Please use
        core\\event\\course_module_instance_list_viewed instead', DEBUG_DEVELOPER);
