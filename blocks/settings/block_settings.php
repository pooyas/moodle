<?php

/**
 * This file contains classes used to manage the navigation structures in Lion
 * and was introduced as part of the changes occuring in Lion 2.0
 *
 * @since Lion 2.0
 * @package block_settings
 * @copyright 2009 Sam Hemelryk
 * 
 */

/**
 * The settings navigation tree block class
 *
 * Used to produce the settings navigation block new to Lion 2.0
 *
 * @package block_settings
 * @copyright 2009 Sam Hemelryk
 * 
 */
class block_settings extends block_base {

    /** @var string */
    public static $navcount;
    public $blockname = null;
    /** @var bool */
    protected $contentgenerated = false;
    /** @var bool|null */
    protected $docked = null;

    /**
     * Set the initial properties for the block
     */
    function init() {
        $this->blockname = get_class($this);
        $this->title = get_string('pluginname', $this->blockname);
    }

    /**
     * All multiple instances of this block
     * @return bool Returns true
     */
    function instance_allow_multiple() {
        return false;
    }

    /**
     * The settings block cannot be hidden by default as it is integral to
     * the navigation of Lion.
     *
     * @return false
     */
    function  instance_can_be_hidden() {
        return false;
    }

    /**
     * Set the applicable formats for this block to all
     * @return array
     */
    function applicable_formats() {
        return array('all' => true);
    }

    /**
     * Allow the user to configure a block instance
     * @return bool Returns true
     */
    function instance_allow_config() {
        return true;
    }

    function instance_can_be_docked() {
        return (parent::instance_can_be_docked() && (empty($this->config->enabledock) || $this->config->enabledock=='yes'));
    }

    function get_required_javascript() {
        parent::get_required_javascript();
        $arguments = array(
            'id' => $this->instance->id,
            'instance' => $this->instance->id,
            'candock' => $this->instance_can_be_docked()
        );
        $this->page->requires->yui_module('lion-block_navigation-navigation', 'M.block_navigation.init_add_tree', array($arguments));
    }

    /**
     * Gets the content for this block by grabbing it from $this->page
     */
    function get_content() {
        global $CFG, $OUTPUT;
        // First check if we have already generated, don't waste cycles
        if ($this->contentgenerated === true) {
            return true;
        }
        // JS for navigation moved to the standard theme, the code will probably have to depend on the actual page structure
        // $this->page->requires->js('/lib/javascript-navigation.js');
        block_settings::$navcount++;

        // Check if this block has been docked
        if ($this->docked === null) {
            $this->docked = get_user_preferences('nav_in_tab_panel_settingsnav'.block_settings::$navcount, 0);
        }

        // Check if there is a param to change the docked state
        if ($this->docked && optional_param('undock', null, PARAM_INT)==$this->instance->id) {
            unset_user_preference('nav_in_tab_panel_settingsnav'.block_settings::$navcount, 0);
            $url = $this->page->url;
            $url->remove_params(array('undock'));
            redirect($url);
        } else if (!$this->docked && optional_param('dock', null, PARAM_INT)==$this->instance->id) {
            set_user_preferences(array('nav_in_tab_panel_settingsnav'.block_settings::$navcount=>1));
            $url = $this->page->url;
            $url->remove_params(array('dock'));
            redirect($url);
        }

        $renderer = $this->page->get_renderer('block_settings');
        $this->content = new stdClass();
        $this->content->text = $renderer->settings_tree($this->page->settingsnav);

        // only do search if you have lion/site:config
        if (!empty($this->content->text)) {
            if (has_capability('lion/site:config',context_system::instance()) ) {
                $this->content->footer = $renderer->search_form(new lion_url("$CFG->wwwroot/$CFG->admin/search.php"), optional_param('query', '', PARAM_RAW));
            } else {
                $this->content->footer = '';
            }

            if (!empty($this->config->enabledock) && $this->config->enabledock == 'yes') {
                user_preference_allow_ajax_update('nav_in_tab_panel_settingsnav'.block_settings::$navcount, PARAM_INT);
            }
        }

        $this->contentgenerated = true;
        return true;
    }

    /**
     * Returns the role that best describes the settings block.
     *
     * @return string 'navigation'
     */
    public function get_aria_role() {
        return 'navigation';
    }
}
