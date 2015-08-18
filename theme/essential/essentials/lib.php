<?php


/**
 * Essentials is a basic child theme of Essential to help you as a theme
 * developer create your own child theme of Essential.
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

function theme_essentials_process_css($css, $theme) {
    // Change to 'true' if you want to use Essential's settings after removing the '$THEME->parents_exclude_sheets' in config.php.
    $usingessentialsettings = false;

    if ($usingessentialsettings) {
        require_once(dirname(__FILE__) . '/../essential/lib.php');
        $css = theme_essential_process_css($css, $theme);
    }

    // If you have your own settings, then add them here.

    // Finally return processed CSS
    return $css;
}

function theme_essentials_set_fontwww($css) {
    global $CFG;
    $fontwww = preg_replace("(https?:)", "", $CFG->wwwroot . '/theme/essential/fonts/');

    $tag = '[[setting:fontwww]]';

    if (theme_essential_get_setting('bootstrapcdn')) {
        $css = str_replace($tag, '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/fonts/', $css);
    } else {
        $css = str_replace($tag, $fontwww, $css);
    }
    return $css;
}

function theme_essentials_page_init(lion_page $page) {
    require_once(dirname(__FILE__) . '/../essential/lib.php');
    theme_essential_page_init($page);
}
