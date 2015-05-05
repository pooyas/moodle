<?php

/**
 * Manage files in folder in private area.
 *
 * This page is not used and now redirects to the page to manage the private files.
 *
 * @package    block
 * @subpackage private_files
 * @copyright  2015 Pooya Saeedi
 * 
 */

require('../../config.php');

redirect(new lion_url('/user/files.php'));
