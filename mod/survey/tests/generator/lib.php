<?php

/**
 * mod_survey data generator.
 *
 * @package    mod_survey
 * @category   test
 * @copyright  2013 Marina Glancy
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * mod_survey data generator class.
 *
 * @package    mod_survey
 * @category   test
 * @copyright  2013 Marina Glancy
 * 
 */
class mod_survey_generator extends testing_module_generator {

    /**
     * Cached list of available templates.
     * @var array
     */
    private $templates = null;

    public function reset() {
        $this->templates = null;
        parent::reset();
    }

    public function create_instance($record = null, array $options = null) {
        global $DB;

        if ($this->templates === null) {
            $this->templates = $DB->get_records_menu('survey', array('template' => 0), 'name', 'id, name');
        }
        if (empty($this->templates)) {
            throw new lion_exception('cannotfindsurveytmpt', 'survey');
        }
        $record = (array)$record;
        if (isset($record['template']) && !is_number($record['template'])) {
            // Substitute template name with template id.
            $record['template'] = array_search($record['template'], $this->templates);
        }
        if (isset($record['template']) && !array_key_exists($record['template'], $this->templates)) {
            throw new lion_exception('cannotfindsurveytmpt', 'survey');
        }

        // Add default values for survey.
        if (!isset($record['template'])) {
            reset($this->templates);
            $record['template'] = key($this->templates);
        }

        return parent::create_instance($record, (array)$options);
    }
}
