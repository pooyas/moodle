<?php


/**
 * Badge assertion library.
 *
 * @package    badges
 * @subpackage classes
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Open Badges Assertions specification 1.0 {@link https://github.com/mozilla/openbadges/wiki/Assertions}
 *
 * Badge asserion is defined by three parts:
 * - Badge Assertion (information regarding a specific badge that was awarded to a badge earner)
 * - Badge Class (general information about a badge and what it is intended to represent)
 * - Issuer Class (general information of an issuing organisation)
 */

/**
 * Class that represents badge assertion.
 *
 */
class core_badges_assertion {
    /** @var object Issued badge information from database */
    private $_data;

    /** @var lion_url Issued badge url */
    private $_url;

    /**
     * Constructs with issued badge unique hash.
     *
     * @param string $hash Badge unique hash from badge_issued table.
     */
    public function __construct($hash) {
        global $DB;

        $this->_data = $DB->get_record_sql('
            SELECT
                bi.dateissued,
                bi.dateexpire,
                bi.uniquehash,
                u.email,
                b.*,
                bb.email as backpackemail
            FROM
                {badge} b
                JOIN {badge_issued} bi
                    ON b.id = bi.badgeid
                JOIN {user} u
                    ON u.id = bi.userid
                LEFT JOIN {badge_backpack} bb
                    ON bb.userid = bi.userid
            WHERE ' . $DB->sql_compare_text('bi.uniquehash', 40) . ' = ' . $DB->sql_compare_text(':hash', 40),
            array('hash' => $hash), IGNORE_MISSING);

        $this->_url = new lion_url('/badges/badge.php', array('hash' => $this->_data->uniquehash));
    }

    /**
     * Get badge assertion.
     *
     * @return array Badge assertion.
     */
    public function get_badge_assertion() {
        global $CFG;
        $assertion = array();
        if ($this->_data) {
            $hash = $this->_data->uniquehash;
            $email = empty($this->_data->backpackemail) ? $this->_data->email : $this->_data->backpackemail;
            $assertionurl = new lion_url('/badges/assertion.php', array('b' => $hash));
            $classurl = new lion_url('/badges/assertion.php', array('b' => $hash, 'action' => 1));

            // Required.
            $assertion['uid'] = $hash;
            $assertion['recipient'] = array();
            $assertion['recipient']['identity'] = 'sha256$' . hash('sha256', $email . $CFG->badges_badgesalt);
            $assertion['recipient']['type'] = 'email'; // Currently the only supported type.
            $assertion['recipient']['hashed'] = true; // We are always hashing recipient.
            $assertion['recipient']['salt'] = $CFG->badges_badgesalt;
            $assertion['badge'] = $classurl->out(false);
            $assertion['verify'] = array();
            $assertion['verify']['type'] = 'hosted'; // 'Signed' is not implemented yet.
            $assertion['verify']['url'] = $assertionurl->out(false);
            $assertion['issuedOn'] = $this->_data->dateissued;
            // Optional.
            $assertion['evidence'] = $this->_url->out(false); // Currently issued badge URL.
            if (!empty($this->_data->dateexpire)) {
                $assertion['expires'] = $this->_data->dateexpire;
            }
        }
        return $assertion;
    }

    /**
     * Get badge class information.
     *
     * @return array Badge Class information.
     */
    public function get_badge_class() {
        $class = array();
        if ($this->_data) {
            if (empty($this->_data->courseid)) {
                $context = context_system::instance();
            } else {
                $context = context_course::instance($this->_data->courseid);
            }
            $issuerurl = new lion_url('/badges/assertion.php', array('b' => $this->_data->uniquehash, 'action' => 0));

            // Required.
            $class['name'] = $this->_data->name;
            $class['description'] = $this->_data->description;
            $class['image'] = lion_url::make_pluginfile_url($context->id, 'badges', 'badgeimage', $this->_data->id, '/', 'f1')->out(false);
            $class['criteria'] = $this->_url->out(false); // Currently issued badge URL.
            $class['issuer'] = $issuerurl->out(false);
        }
        return $class;
    }

    /**
     * Get badge issuer information.
     *
     * @return array Issuer information.
     */
    public function get_issuer() {
        $issuer = array();
        if ($this->_data) {
            // Required.
            $issuer['name'] = $this->_data->issuername;
            $issuer['url'] = $this->_data->issuerurl;
            // Optional.
            if (!empty($this->_data->issuercontact)) {
                $issuer['email'] = $this->_data->issuercontact;
            }
        }
        return $issuer;
    }

}
