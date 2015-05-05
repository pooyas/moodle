<?php

/**
 * Admin Bookmarks Block page.
 *
 * @package    block
 * @subpackage admin_bookmarks
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * The admin bookmarks block class
 */
class block_admin_bookmarks extends block_base {

    /** @var string */
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
     * @return bool Returns false
     */
    function instance_allow_multiple() {
        return false;
    }

    /**
     * Set the applicable formats for this block to all
     * @return array
     */
    function applicable_formats() {
        if (has_capability('lion/site:config', context_system::instance())) {
            return array('all' => true);
        } else {
            return array('site' => true);
        }
    }

    /**
     * Gets the content for this block
     */
    function get_content() {

        global $CFG;

        // First check if we have already generated, don't waste cycles
        if ($this->contentgenerated === true) {
            return $this->content;
        }
        $this->content = new stdClass();

        if (get_user_preferences('admin_bookmarks')) {
            require_once($CFG->libdir.'/adminlib.php');
            $adminroot = admin_get_root(false, false);  // settings not required - only pages

            $bookmarks = explode(',', get_user_preferences('admin_bookmarks'));
            /// Accessibility: markup as a list.
            $contents = array();
            foreach($bookmarks as $bookmark) {
                $temp = $adminroot->locate($bookmark);
                if ($temp instanceof admin_settingpage) {
                    $contenturl = new lion_url('/admin/settings.php', array('section'=>$bookmark));
                    $contentlink = html_writer::link($contenturl, $temp->visiblename);
                    $contents[] = html_writer::tag('li', $contentlink);
                } else if ($temp instanceof admin_externalpage) {
                    $contenturl = new lion_url($temp->url);
                    $contentlink = html_writer::link($contenturl, $temp->visiblename);
                    $contents[] = html_writer::tag('li', $contentlink);
                }
            }
            $this->content->text = html_writer::tag('ol', implode('', $contents), array('class' => 'list'));
        } else {
            $bookmarks = array();
        }

        $this->content->footer = '';
        $this->page->settingsnav->initialise();
        $node = $this->page->settingsnav->get('root', navigation_node::TYPE_SITE_ADMIN);
        if (!$node || !$node->contains_active_node()) {
            return $this->content;
        }
        $section = $node->find_active_node()->key;

        if ($section == 'search' || empty($section)){
            // the search page can't be properly bookmarked at present
            $this->content->footer = '';
        } else if (in_array($section, $bookmarks)) {
            $deleteurl = new lion_url('/blocks/admin_bookmarks/delete.php', array('section'=>$section, 'sesskey'=>sesskey()));
            $this->content->footer =  html_writer::link($deleteurl, get_string('unbookmarkthispage','admin'));
        } else {
            $createurl = new lion_url('/blocks/admin_bookmarks/create.php', array('section'=>$section, 'sesskey'=>sesskey()));
            $this->content->footer = html_writer::link($createurl, get_string('bookmarkthispage','admin'));
        }

        return $this->content;
    }

    /**
     * Returns the role that best describes the admin bookmarks block.
     *
     * @return string
     */
    public function get_aria_role() {
        return 'navigation';
    }
}


