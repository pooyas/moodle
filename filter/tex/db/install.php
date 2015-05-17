<?php



/**
 * Tex filter post install hook
 *
 * @package    filter
 * @subpackage tex
 * @copyright  2015 Pooya Saeedi
 */

function xmldb_filter_tex_install() {
    global $CFG;

    // purge all caches during installation

    require_once("$CFG->dirroot/filter/tex/lib.php");
    filter_tex_updatedcallback(null);
}

