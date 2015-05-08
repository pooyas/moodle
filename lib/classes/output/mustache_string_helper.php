<?php

/**
 * Mustache helper to load strings from string_manager.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\output;

use Mustache_LambdaHelper;
use stdClass;

/**
 * This class will load language strings in a template.
 *
 */
class mustache_string_helper {

    /**
     * Read a lang string from a template and get it from get_string.
     *
     * Some examples for calling this from a template are:
     *
     * {{#str}}activity{{/str}}
     * {{#str}}actionchoice, core, {{#str}}delete{{/str}}{{/str}} (Nested)
     * {{#str}}addinganewto, core, {"what":"This", "to":"That"}{{/str}} (Complex $a)
     *
     * The args are comma separated and only the first is required.
     * The last is a $a argument for get string. For complex data here, use JSON.
     *
     * @param string $text The text to parse for arguments.
     * @param Mustache_LambdaHelper $helper Used to render nested mustache variables.
     * @return string
     */
    public function str($text, Mustache_LambdaHelper $helper) {
        // Split the text into an array of variables.
        $key = strtok($text, ",");
        $key = trim($key);
        $component = strtok(",");
        $component = trim($component);
        if (!$component) {
            $component = '';
        }

        $a = new stdClass();

        $next = strtok('');
        $next = trim($next);
        if ((strpos($next, '{') === 0) && (strpos($next, '{{') !== 0)) {
            $rawjson = $helper->render($next);
            $a = json_decode($rawjson);
        } else {
            $a = $helper->render($next);
        }
        return get_string($key, $component, $a);
    }
}

