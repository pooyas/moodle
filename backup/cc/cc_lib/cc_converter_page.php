<?php
/**
 * @package    backup-convert
 * @subpackage cc-library
 * @copyright  2011 Darko Miletic <dmiletic@lionrooms.com>
 * 
 */

require_once 'cc_converters.php';
require_once 'cc_general.php';
require_once 'cc_page.php';

class cc_converter_page extends cc_converter {
    public function __construct(cc_i_item &$item, cc_i_manifest &$manifest, $rootpath, $path){
        $this->cc_type     = cc_version11::webcontent;
        $this->defaultfile = 'page.xml';
        $this->defaultname = uniqid().'.html';
        parent::__construct($item, $manifest, $rootpath, $path);
    }

    public function convert($outdir) {
        $rt = new page11_resurce_file();
        $title = $this->doc->nodeValue('/activity/page/name');
        $intro = $this->doc->nodeValue('/activity/page/intro');
        $contextid = $this->doc->nodeValue('/activity/@contextid');
        $pagecontent = $this->doc->nodeValue('/activity/page/content');
        $rt->set_title($title);
        $rawname = str_replace(' ', '_', strtolower(trim(clean_param($title, PARAM_FILE))));
        if (!empty($rawname)) {
            $this->defaultname = $rawname.".html";
        }

        $result = cc_helpers::process_linked_files( $pagecontent,
                                                    $this->manifest,
                                                    $this->rootpath,
                                                    $contextid,
                                                    $outdir,
                                                    true);
        $rt->set_content($result[0]);
        $rt->set_intro($intro);
        //store everything
        $this->store($rt, $outdir, $title, $result[1]);
        return true;
    }
}
