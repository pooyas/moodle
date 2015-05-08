<?php
/**
 * Abstract event for content viewing.
 *
 * This class has been deprecated, please extend base event or other relevent abstract class.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * @deprecated
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

debugging('core\event\content_viewed has been deprecated. Please extend base event or other relevant abstract class.',
        DEBUG_DEVELOPER);

/**
 * Class content_viewed.
 *
 * This class has been deprecated, please extend base event or other relevent abstract class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string content: name of the content viewed.
 * }
 *
 */
abstract class content_viewed extends base {

    /** @var null|array $legacylogdata  Legacy log data */
    protected $legacylogdata = null;

    /**
     * Set basic properties of the event.
     */
    protected function init() {
        global $PAGE;

        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->context = $PAGE->context;
    }

    /**
     * Set basic page properties.
     */
    public function set_page_detail() {
        global $PAGE;
        if (!isset($this->data['other'])) {
            $this->data['other'] = array();
        }
        $this->data['other'] = array_merge(array('url'     => $PAGE->url->out_as_local_url(false),
                                             'heading'     => $PAGE->heading,
                                             'title'       => $PAGE->title), $this->data['other']);
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcontentviewed', 'lion');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed content.";
    }

    /**
     * Set legacy logdata.
     *
     * @param array $legacydata legacy logdata.
     */
    public function set_legacy_logdata(array $legacydata) {
        $this->legacylogdata = $legacydata;
    }

    /**
     * Get legacy logdata.
     *
     * @return null|array legacy log data.
     */
    protected function get_legacy_logdata() {
        return $this->legacylogdata;
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception when validation does not pass.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        // Make sure this class is never used without a content identifier.
        if (empty($this->other['content'])) {
            throw new \coding_exception('The \'content\' value must be set in other.');
        }
    }
}

