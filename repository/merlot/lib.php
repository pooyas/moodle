<?php

/**
 * This plugin is used to access merlot files
 *
 * @since Lion 2.0
 * @package    repository_merlot
 * @copyright  2010 Dongsheng Cai {@link http://dongsheng.org}
 * 
 */
require_once($CFG->dirroot . '/repository/lib.php');

/**
 * repository_merlot is used to search merlot.org in lion
 *
 * @since Lion 2.0
 * @package    repository_merlot
 * @copyright  2009 Dongsheng Cai {@link http://dongsheng.org}
 * 
 */
class repository_merlot extends repository {

    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = array()) {
        parent::__construct($repositoryid, $context, $options);
        $this->keyword = optional_param('merlot_keyword', '', PARAM_RAW);
        $this->author = optional_param('merlot_author', '', PARAM_RAW);
        $this->licensekey = trim(get_config('merlot', 'licensekey'));
    }

    /**
     * Display login screen or not
     *
     * @return boolean
     */
    public function check_login() {
        return !empty($this->keyword);
    }

    /**
     * Doesn't support global search
     *
     * @return boolean
     */
    public function global_search() {
        return false;
    }

    /**
     * Look for a link in merlot.org
     * @param string $search_text
     * @return array
     */
    public function search($search_text, $page = 0) {
        $ret  = array();
        $ret['nologin'] = true;
        $ret['list'] = $this->_get_collection($this->keyword, $this->author);
        return $ret;
    }

    /**
     * Get a list of links
     * @return array
     */
    public function get_listing($path = '', $page = '') {
        $ret  = array();
        $ret['nologin'] = true;
        $ret['list'] = $this->_get_collection($this->keyword);
        return $ret;
    }

    private function _get_collection($keyword) {
        global $OUTPUT;
        $list = array();
        $this->api = 'http://www.merlot.org/merlot/materials.rest?keywords=' . urlencode($keyword) . '&licenseKey='.$this->licensekey;
        $c = new curl(array('cache'=>true, 'module_cache'=>'repository'));
        $content = $c->get($this->api);
        $xml = simplexml_load_string($content);
        foreach ($xml->results->material as $entry) {
            $list[] = array(
                'title'=>(string)$entry->title,
                'thumbnail'=>$OUTPUT->pix_url(file_extension_icon($entry->title, 90))->out(false),
                'date'=>userdate((int)$entry->creationDate),
                'size'=>'',
                'source'=>(string)$entry->URL
            );
        }
        return $list;
    }

    /**
     * Define a search form
     *
     * @return array
     */
    public function print_login(){
        $ret = array();
        $search = new stdClass();
        $search->type = 'text';
        $search->id   = 'merlog_search';
        $search->name = 'merlot_keyword';
        $search->label = get_string('search').': ';
        $author = new stdClass();
        $author->type = 'text';
        $author->id   = 'merlog_author';
        $author->name = 'merlot_author';
        $author->label = get_string('author', 'search').': ';

        $ret['login'] = array($search, $author);
        $ret['login_btn_label'] = get_string('search');
        $ret['login_btn_action'] = 'search';
        return $ret;
    }

    /**
     * Names of the plugin settings
     *
     * @return array
     */
    public static function get_type_option_names() {
        return array('licensekey', 'pluginname');
    }

    /**
     * Add Plugin settings input to Lion form
     *
     * @param object $mform
     */
    public static function type_config_form($mform, $classname = 'repository') {
        parent::type_config_form($mform);
        $licensekey = get_config('merlot', 'licensekey');
        if (empty($licensekey)) {
            $licensekey = '';
        }
        $strrequired = get_string('required');
        $mform->addElement('text', 'licensekey', get_string('licensekey', 'repository_merlot'), array('value'=>$licensekey,'size' => '40'));
        $mform->setType('licensekey', PARAM_RAW_TRIMMED);
        $mform->addRule('licensekey', $strrequired, 'required', null, 'client');
    }

    /**
     * Support external link only
     *
     * @return int
     */
    public function supported_returntypes() {
        return FILE_EXTERNAL;
    }
    public function supported_filetypes() {
        return array('link');
    }

    /**
     * Is this repository accessing private data?
     *
     * @return bool
     */
    public function contains_private_data() {
        return false;
    }
}

