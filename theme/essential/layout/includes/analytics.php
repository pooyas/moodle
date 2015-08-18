<?php


/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Lion's new Bootstrap theme engine
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

if ($OUTPUT->get_setting('analyticsenabled')) {
    $analytics = $OUTPUT->get_setting('analytics');
    if ($analytics === "piwik") {
        require_once($OUTPUT->get_include_file('piwik'));
    } elseif ($analytics === "guniversal") {
        require_once($OUTPUT->get_include_file('guniversal'));
    }
}