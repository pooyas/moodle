<?php

/**
 * This filter provides automatic support for MathJax
 *
 * @package    filter_mathjaxloader
 * @copyright  2013 Damyon Wiese (damyon@lion.com)
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Mathjax filtering
 */
class filter_mathjaxloader extends lion_text_filter {

    /*
     * Perform a mapping of the lion language code to the equivalent for MathJax.
     *
     * @param string $lionlangcode - The lion language code - e.g. en_pirate
     * @return string The MathJax language code.
     */
    public function map_language_code($lionlangcode) {
        $mathjaxlangcodes = array('br',
                                  'cdo',
                                  'cs',
                                  'da',
                                  'de',
                                  'en',
                                  'eo',
                                  'es',
                                  'fa',
                                  'fi',
                                  'fr',
                                  'gl',
                                  'he',
                                  'ia',
                                  'it',
                                  'ja',
                                  'ko',
                                  'lb',
                                  'mk',
                                  'nl',
                                  'oc',
                                  'pl',
                                  'pt',
                                  'pt-br',
                                  'ru',
                                  'sl',
                                  'sv',
                                  'tr',
                                  'uk',
                                  'zh-hans');
        $exceptions = array('cz' => 'cs');

        // First see if this is an exception.
        if (isset($exceptions[$lionlangcode])) {
            $lionlangcode = $exceptions[$lionlangcode];
        }

        // Now look for an exact lang string match.
        if (in_array($lionlangcode, $mathjaxlangcodes)) {
            return $lionlangcode;
        }

        // Now try shortening the lion lang string.
        $lionlangcode = preg_replace('/-.*/', '', $lionlangcode);
        // Look for a match on the shortened string.
        if (in_array($lionlangcode, $mathjaxlangcodes)) {
            return $lionlangcode;
        }
        // All failed - use english.
        return 'en';
    }

    /*
     * Add the javascript to enable mathjax processing on this page.
     *
     * @param lion_page $page The current page.
     * @param context $context The current context.
     */
    public function setup($page, $context) {
        // This only requires execution once per request.
        static $jsinitialised = false;

        if (empty($jsinitialised)) {
            if (is_https()) {
                $url = get_config('filter_mathjaxloader', 'httpsurl');
            } else {
                $url = get_config('filter_mathjaxloader', 'httpurl');
            }
            $lang = $this->map_language_code(current_language());
            $url = new lion_url($url, array('delayStartupUntil' => 'configured'));

            $moduleconfig = array(
                'name' => 'mathjax',
                'fullpath' => $url
            );

            $page->requires->js_module($moduleconfig);

            $config = get_config('filter_mathjaxloader', 'mathjaxconfig');

            $params = array('mathjaxconfig' => $config, 'lang' => $lang);

            $page->requires->yui_module('lion-filter_mathjaxloader-loader', 'M.filter_mathjaxloader.configure', array($params));

            $jsinitialised = true;
        }
    }

    /*
     * This function wraps the filtered text in a span, that mathjaxloader is configured to process.
     *
     * @param string $text The text to filter.
     * @param array $options The filter options.
     */
    public function filter($text, array $options = array()) {
        global $PAGE;

        $legacy = get_config('filter_mathjaxloader', 'texfiltercompatibility');
        $extradelimiters = explode(',', get_config('filter_mathjaxloader', 'additionaldelimiters'));
        if ($legacy) {
            // This replaces any of the tex filter maths delimiters with the default for inline maths in MathJAX "\( blah \)".
            // E.g. "<tex.*> blah </tex>".
            $text = preg_replace('|<(/?) *tex( [^>]*)?>|u', '[\1tex]', $text);
            // E.g. "[tex.*] blah [/tex]".
            $text = str_replace('[tex]', '\\(', $text);
            $text = str_replace('[/tex]', '\\)', $text);
            // E.g. "$$ blah $$".
            $text = preg_replace('|\$\$([\S\s]*?)\$\$|u', '\\(\1\\)', $text);
            // E.g. "\[ blah \]".
            $text = str_replace('\\[', '\\(', $text);
            $text = str_replace('\\]', '\\)', $text);
        }

        $hasinline = strpos($text, '\\(') !== false && strpos($text, '\\)') !== false;
        $hasdisplay = (strpos($text, '$$') !== false) ||
                      (strpos($text, '\\[') !== false && strpos($text, '\\]') !== false);

        $hasextra = false;

        foreach ($extradelimiters as $extra) {
            if ($extra && strpos($text, $extra) !== false) {
                $hasextra = true;
                break;
            }
        }
        if ($hasinline || $hasdisplay || $hasextra) {
            $PAGE->requires->yui_module('lion-filter_mathjaxloader-loader', 'M.filter_mathjaxloader.typeset');
            return '<span class="nolink"><span class="filter_mathjaxloader_equation">' . $text . '</span></span>';
        }
        return $text;
    }
}
