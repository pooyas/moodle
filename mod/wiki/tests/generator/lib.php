<?php

/**
 * mod_wiki data generator.
 *
 * @package    mod_wiki
 * @category   test
 * @copyright  2013 Marina Glancy
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * mod_wiki data generator class.
 *
 * @package    mod_wiki
 * @category   test
 * @copyright  2013 Marina Glancy
 * 
 */
class mod_wiki_generator extends testing_module_generator {

    /**
     * @var int keep track of how many pages have been created.
     */
    protected $pagecount = 0;

    /**
     * To be called from data reset code only,
     * do not use in tests.
     * @return void
     */
    public function reset() {
        $this->pagecount = 0;
        parent::reset();
    }

    public function create_instance($record = null, array $options = null) {
        // Add default values for wiki.
        $record = (array)$record + array(
            'wikimode' => 'collaborative',
            'firstpagetitle' => 'Front page for wiki '.($this->instancecount+1),
            'defaultformat' => 'html',
            'forceformat' => 0
        );

        return parent::create_instance($record, (array)$options);
    }

    public function create_content($wiki, $record = array()) {
        $record = (array)$record + array(
            'wikiid' => $wiki->id
        );
        return $this->create_page($wiki, $record);
    }

    public function create_first_page($wiki, $record = array()) {
        $record = (array)$record + array(
            'title' => $wiki->firstpagetitle,
        );
        return $this->create_page($wiki, $record);
    }

    /**
     * Generates a page in wiki.
     *
     * @param stdClass wiki object returned from create_instance (if known)
     * @param stdClass|array $record data to insert as wiki entry.
     * @return stdClass
     * @throws coding_exception if neither $record->wikiid nor $wiki->id is specified
     */
    public function create_page($wiki, $record = array()) {
        global $CFG, $USER;
        require_once($CFG->dirroot.'/mod/wiki/locallib.php');
        $this->pagecount++;
        $record = (array)$record + array(
            'title' => 'wiki page '.$this->pagecount,
            'wikiid' => $wiki->id,
            'subwikiid' => 0,
            'group' => 0,
            'content' => 'Wiki page content '.$this->pagecount,
            'format' => $wiki->defaultformat
        );
        if (empty($record['wikiid']) && empty($record['subwikiid'])) {
            throw new coding_exception('wiki page generator requires either wikiid or subwikiid');
        }
        if (!$record['subwikiid']) {
            if (!isset($record['userid'])) {
                $record['userid'] = ($wiki->wikimode == 'individual') ? $USER->id : 0;
            }
            if ($subwiki = wiki_get_subwiki_by_group($record['wikiid'], $record['group'], $record['userid'])) {
                $record['subwikiid'] = $subwiki->id;
            } else {
                $record['subwikiid'] = wiki_add_subwiki($record['wikiid'], $record['group'], $record['userid']);
            }
        }

        if ($wikipage = wiki_get_page_by_title($record['subwikiid'], $record['title'])) {
            $rv = wiki_save_page($wikipage, $record['content'], $USER->id);
            return $rv['page'];
        }

        $pageid = wiki_create_page($record['subwikiid'], $record['title'], $record['format'], $USER->id);
        $wikipage = wiki_get_page($pageid);
        $rv = wiki_save_page($wikipage, $record['content'], $USER->id);
        return $rv['page'];
    }
}
