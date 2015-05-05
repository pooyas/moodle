<?php

/**
 * IMS Enterprise enrol plugin implementation.
 *
 * @package    enrol
 * @subpackage imsenterprise
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();


/**
 * Class for dealing with role mappings in IMS Enterprise.
 *
 */
class imsenterprise_roles {
    /** @var imscode => ims role name. Role name mapping. */
    private $imsroles;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->imsroles = array(
            '01' => 'Learner',
            '02' => 'Instructor',
            '03' => 'Content Developer',
            '04' => 'Member',
            '05' => 'Manager',
            '06' => 'Mentor',
            '07' => 'Administrator',
            '08' => 'TeachingAssistant',
        );
        // PLEASE NOTE: It may seem odd that "Content Developer" has a space in it
        // but "TeachingAssistant" doesn't. That's what the spec says though!!!
    }

    /**
     * Returns the mapped roles
     *
     * @return array of IMS roles indexed by IMS code.
     */
    public function get_imsroles() {
        return $this->imsroles;
    }

    /**
     * This function is only used when first setting up the plugin, to
     * decide which role assignments to recommend by default.
     * For example, IMS role '01' is 'Learner', so may map to 'student' in Lion.
     *
     * @param string $imscode
     */
    public function determine_default_rolemapping($imscode) {
        global $DB;

        switch($imscode) {
            case '01':
            case '04':
                $shortname = 'student';
                break;
            case '06':
            case '08':
                $shortname = 'teacher';
                break;
            case '02':
            case '03':
                $shortname = 'editingteacher';
                break;
            case '05':
            case '07':
                $shortname = 'admin';
                break;
            default:
                return 0; // Zero for no match.
        }
        return (string)$DB->get_field('role', 'id', array('shortname' => $shortname));
    }


}


/**
 * Mapping between Lion course attributes and IMS enterprise group description tags
 *
 */
class imsenterprise_courses {
    /** @var array IMS group description names */
    private $imsnames;
    /** @var array lion course field names */
    private $courseattrs;

    /**
     * Loads default
     */
    public function __construct() {
        $this->imsnames = array(
            'short' => 'short',
            'long' => 'long',
            'full' => 'full',
            'coursecode' => 'coursecode');
        $this->courseattrs = array('shortname', 'fullname', 'summary');
    }

    /**
     * Returns the assignable values for the course attribute
     * @param string $courseattr The course attribute (shortname, fullname...)
     * @return array Array of assignable values
     */
    public function get_imsnames($courseattr) {

        $values = $this->imsnames;
        if ($courseattr == 'summary') {
            $values = array_merge(array('ignore' => get_string('emptyattribute', 'enrol_imsenterprise')), $values);
        }
        return $values;
    }

    /**
     * courseattrs getter
     * @return array
     */
    public function get_courseattrs() {
        return $this->courseattrs;
    }

    /**
     * This function is only used when first setting up the plugin, to
     * decide which name assignments to recommend by default.
     *
     * @param string $courseattr
     * @return string
     */
    public function determine_default_coursemapping($courseattr) {
        switch($courseattr) {
            case 'fullname':
                $imsname = 'short';
                break;
            case 'shortname':
                $imsname = 'coursecode';
                break;
            default:
                $imsname = 'ignore';
        }

        return $imsname;
    }
}
