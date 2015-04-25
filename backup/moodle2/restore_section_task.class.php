<?php

/**
 * Defines restore_section_task class
 *
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

/**
 * section task that provides all the properties and common steps to be performed
 * when one section is being restored
 *
 * TODO: Finish phpdocs
 */
class restore_section_task extends restore_task {

    protected $info; // info related to section gathered from backup file
    protected $contextid; // course context id
    protected $sectionid; // new (target) id of the course section

    /**
     * Constructor - instantiates one object of this class
     */
    public function __construct($name, $info, $plan = null) {
        $this->info = $info;
        $this->sectionid = 0;
        parent::__construct($name, $plan);
    }

    /**
     * Section tasks have their own directory to read files
     */
    public function get_taskbasepath() {

        return $this->get_basepath() . '/sections/section_' . $this->info->sectionid;
    }

    public function set_sectionid($sectionid) {
        $this->sectionid = $sectionid;
    }

    public function get_contextid() {
        return $this->contextid;
    }

    public function get_sectionid() {
        return $this->sectionid;
    }

    /**
     * Create all the steps that will be part of this task
     */
    public function build() {

        // Define the task contextid (the course one)
        $this->contextid = context_course::instance($this->get_courseid())->id;

        // We always try to restore as much info from sections as possible, no matter of the type
        // of restore (new, existing, deleting, import...). MDL-27764
        $this->add_step(new restore_section_structure_step('course_info', 'section.xml'));

        // At the end, mark it as built
        $this->built = true;
    }

    /**
     * Exceptionally override the execute method, so, based in the section_included setting, we are able
     * to skip the execution of one task completely
     */
    public function execute() {

        // Find activity_included_setting
        if (!$this->get_setting_value('included')) {
            $this->log('activity skipped by _included setting', backup::LOG_DEBUG, $this->name);

        } else { // Setting tells us it's ok to execute
            parent::execute();
        }
    }

    /**
     * Specialisation that, first of all, looks for the setting within
     * the task with the the prefix added and later, delegates to parent
     * without adding anything
     */
    public function get_setting($name) {
        $namewithprefix = 'section_' . $this->info->sectionid . '_' . $name;
        $result = null;
        foreach ($this->settings as $key => $setting) {
            if ($setting->get_name() == $namewithprefix) {
                if ($result != null) {
                    throw new base_task_exception('multiple_settings_by_name_found', $namewithprefix);
                } else {
                    $result = $setting;
                }
            }
        }
        if ($result) {
            return $result;
        } else {
            // Fallback to parent
            return parent::get_setting($name);
        }
    }

    /**
     * Define the contents in the course that must be
     * processed by the link decoder
     */
    static public function define_decode_contents() {
        $contents = array();

        $contents[] = new restore_decode_content('course_sections', 'summary', 'course_section');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the sections to be executed by the link decoder
     */
    static public function define_decode_rules() {
        return array();
    }

// Protected API starts here

    /**
     * Define the common setting that any restore section will have
     */
    protected function define_settings() {

        // All the settings related to this activity will include this prefix
        $settingprefix = 'section_' . $this->info->sectionid . '_';

        // All these are common settings to be shared by all sections

        // Define section_included (to decide if the whole task must be really executed)
        $settingname = $settingprefix . 'included';
        $section_included = new restore_section_included_setting($settingname, base_setting::IS_BOOLEAN, true);
        if (is_number($this->info->title)) {
            $label = get_string('includesection', 'backup', $this->info->title);
        } elseif (empty($this->info->title)) { // Don't throw error if title is empty, gracefully continue restore.
            $this->log('Section title missing in backup for section id '.$this->info->sectionid, backup::LOG_WARNING, $this->name);
            $label = get_string('unnamedsection', 'backup');
        } else {
            $label = $this->info->title;
        }
        $section_included->get_ui()->set_label($label);
        $this->add_setting($section_included);

        // Define section_userinfo. Dependent of:
        // - users root setting
        // - section_included setting.
        $settingname = $settingprefix . 'userinfo';
        $defaultvalue = false;
        if (isset($this->info->settings[$settingname]) && $this->info->settings[$settingname]) { // Only enabled when available
            $defaultvalue = true;
        }

        $section_userinfo = new restore_section_userinfo_setting($settingname, base_setting::IS_BOOLEAN, $defaultvalue);
        if (!$defaultvalue) {
            // This is a bit hacky, but if there is no user data to restore, then
            // we replace the standard check-box with a select menu with the
            // single choice 'No', and the select menu is clever enough that if
            // there is only one choice, it just displays a static string.
            //
            // It would probably be better design to have a special UI class
            // setting_ui_checkbox_or_no, rather than this hack, but I am not
            // going to do that today.
            $section_userinfo->set_ui(new backup_setting_ui_select($section_userinfo, get_string('includeuserinfo','backup'),
                    array(0 => get_string('no'))));
        } else {
            $section_userinfo->get_ui()->set_label(get_string('includeuserinfo','backup'));
        }

        $this->add_setting($section_userinfo);

        // Look for "users" root setting.
        $users = $this->plan->get_setting('users');
        $users->add_dependency($section_userinfo);

        // Look for "section_included" section setting.
        $section_included->add_dependency($section_userinfo);
    }
}
