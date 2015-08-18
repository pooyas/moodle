<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */
global $CFG;

require_once('renderers/core_renderer.php');

require_once('renderers/format_topics_renderer.php');
require_once('renderers/format_weeks_renderer.php');
require_once('renderers/format_topcoll_renderer.php');
require_once('renderers/format_grid_renderer.php');
require_once('renderers/format_noticebd_renderer.php');
require_once('renderers/format_columns_renderer.php');

if (theme_essential_get_setting('enablecategoryicon')) {
    require_once('renderers/core_course_renderer.php');
}

if (intval($CFG->version) >= 2013111800) {
    require_once('renderers/core_renderer_maintenance.php');
    require_once('renderers/core_course_management_renderer.php');
}