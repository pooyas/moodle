<?php


/**
 * Development data generator.
 *
 * @package    admin_tool
 * @subpackage generator
 * @copyright  2015 Pooya Saeedi
 */
require(dirname(__FILE__) . '/../../../config.php');

// This index page was previously in use, for now we redirect to the make test
// course page - but we might reinstate this page in the future.
redirect(new lion_url('/admin/tool/generator/maketestcourse.php'));
