<?php



/**
 * Basic email protection filter.
 *
 * @package    filter
 * @subpackage emailprotect
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * This class looks for email addresses in Lion text and
 * hides them using the Lion obfuscate_text function.
 */
class filter_emailprotect extends lion_text_filter {
    function filter($text, array $options = array()) {
    /// Do a quick check using stripos to avoid unnecessary work
        if (strpos($text, '@') === false) {
            return $text;
        }

    /// There might be an email in here somewhere so continue ...
        $matches = array();

    /// regular expression to define a standard email string.
        $emailregex = '((?:[\w\.\-])+\@(?:(?:[a-zA-Z\d\-])+\.)+(?:[a-zA-Z\d]{2,4}))';

    /// pattern to find a mailto link with the linked text.
        $pattern = '|(<a\s+href\s*=\s*[\'"]?mailto:)'.$emailregex.'([\'"]?\s*>)'.'(.*)'.'(</a>)|iU';
        $text = preg_replace_callback($pattern, 'filter_emailprotect_alter_mailto', $text);

    /// pattern to find any other email address in the text.
        $pattern = '/(^|\s+|>)'.$emailregex.'($|\s+|\.\s+|\.$|<)/i';
        $text = preg_replace_callback($pattern, 'filter_emailprotect_alter_email', $text);

        return $text;
    }
}


function filter_emailprotect_alter_email($matches) {
    return $matches[1].obfuscate_text($matches[2]).$matches[3];
}

function filter_emailprotect_alter_mailto($matches) {
    return obfuscate_mailto($matches[2], $matches[4]);
}


