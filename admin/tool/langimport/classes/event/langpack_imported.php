<?php

/**
 * The langimport langpack imported event.
 *
 * @package    tool_langimport
 * @copyright  2014 Dan Poltawski <dan@lion.com>
 * 
 */

namespace tool_langimport\event;

defined('LION_INTERNAL') || die();

/**
 * The tool_langimport langpack imported event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string langcode: the langpage pack code.
 * }
 *
 * @package    tool_langimport
 * @since      Lion 2.8
 * @copyright  2014 Dan Poltawski <dan@lion.com>
 * 
 */
class langpack_imported extends \core\event\base {
    /**
     * Create instance of event.
     *
     * @param string $langcode
     * @return langpack_updated
     */
    public static function event_with_langcode($langcode) {
        $data = array(
            'context' => \context_system::instance(),
            'other' => array(
                'langcode' => $langcode,
            )
        );

        return self::create($data);
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The language pack '{$this->other['langcode']}' was installed.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('langpackinstalledevent', 'tool_langimport');
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/admin/tool/langimport/');
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['langcode'])) {
            throw new \coding_exception('The \'langcode\' value must be set');
        }
        // We can't use PARAM_LANG here as the string manager might not be aware of langpack yet.
        $cleanedlang = clean_param($this->other['langcode'], PARAM_SAFEDIR);
        if ($cleanedlang !== $this->other['langcode']) {
            throw new \coding_exception('The \'langcode\' value must be set to a valid language code');
        }
    }
}
