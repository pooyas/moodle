<?php
/**
 * @package    backup
 * @subpackage convert
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once 'cc_converters.php';
require_once 'cc_general.php';
require_once 'cc_weblink.php';

class cc_converter_url extends cc_converter {

    public function __construct(cc_i_item &$item, cc_i_manifest &$manifest, $rootpath, $path){
        $this->cc_type     = cc_version11::weblink;
        $this->defaultfile = 'url.xml';
        $this->defaultname = 'weblink.xml';
        parent::__construct($item, $manifest, $rootpath, $path);
    }

    public function convert($outdir) {
        $rt = new url11_resurce_file();
        $title = $this->doc->nodeValue('/activity/url/name');
        $rt->set_title($title);
        $url = $this->doc->nodeValue('/activity/url/externalurl');
        if (!empty($url)) {
            /**
             *
             * Display value choices
             * 0 - automatic (system chooses what to do) (usualy defaults to the open)
             * 1 - embed - display within a frame
             * 5 - open - just open it full in the same frame
             * 6 - in popup - popup - new frame
             */
            $display = intval($this->doc->nodeValue('/activity/forum/display'));
            $target = ($display == 6) ? '_blank' : '_self';
            //TODO: Lion also supports custom parameters
            //this should be transformed somehow into url where possible
            $rt->set_url($url, $target);
        }

        $this->store($rt, $outdir, $title);
        return true;
    }

}

