<?php

defined('LION_INTERNAL') || die();

/**
 * Plugin for spell checking (Lion custom replacement for standard TinyMCE
 * plugin, but with same name, which seems a bit unhelpful).
 *
 * @package   tinymce_spellchecker
 * @copyright 2012 The Open University
 * 
 */
class tinymce_spellchecker extends editor_tinymce_plugin {
    /** @var array list of buttons defined by this plugin */
    protected $buttons = array('spellchecker');

    protected function update_init_params(array &$params, context $context,
            array $options = null) {
        global $CFG;

        if (!$this->is_legacy_browser()) {
            return;
        }

        // Check some speller is configured.
        $engine = $this->get_config('spellengine', '');
        if (!$engine or $engine === 'GoogleSpell') {
            return;
        }

        // Check at least one language is supported.
        $spelllanguagelist = $this->get_config('spelllanguagelist', '');
        if ($spelllanguagelist !== '') {
            // Prevent the built-in spell checker in Firefox, Safari and other sane browsers.
            unset($params['gecko_spellcheck']);

            if ($row = $this->find_button($params, 'code')) {
                // Add button after 'code'.
                $this->add_button_after($params, $row, 'spellchecker', 'code');
            }

            // Add JS file, which uses default name.
            $this->add_js_plugin($params);
            $params['spellchecker_rpc_url'] = $CFG->httpswwwroot .
                    '/lib/editor/tinymce/plugins/spellchecker/rpc.php';
            $params['spellchecker_languages'] = $spelllanguagelist;
        }
    }

    protected function is_legacy_browser() {
        // IE8 and IE9 are the only supported browsers that do not have spellchecker.
        if (core_useragent::is_ie() and !core_useragent::check_ie_version(10)) {
            return true;
        }
        // The rest of browsers supports spellchecking or is horribly outdated and we do not care...
        return false;
    }
}
