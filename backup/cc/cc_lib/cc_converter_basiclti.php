<?php
/**
 *
 * @package backup
 * @subpackage lib
 * @copyright 2015 Pooya Saeedi
 */


require_once 'cc_converters.php';
require_once 'cc_general.php';
require_once 'cc_basiclti.php';

class cc_converter_basiclti extends cc_converter {

    public function __construct(cc_i_item &$item, cc_i_manifest &$manifest, $rootpath, $path){
        $this->cc_type     = cc_version11::basiclti;
        $this->defaultfile = 'basiclti.xml';
        $this->defaultname = basicltil1_resurce_file::deafultname;
        parent::__construct($item, $manifest, $rootpath, $path);
    }

    public function convert($outdir) {
        $rt = new basicltil1_resurce_file();
        $title = $this->doc->nodeValue('/activity/basiclti/name');
        $rt->set_title($title);
        $rt->set_launch_url($this->doc->nodeValue('/activity/basiclti/toolurl'));
        $rt->set_launch_icon('');
        $rt->set_vendor_code($this->doc->nodeValue('/activity/basiclti/organizationid'));
        $rt->set_vendor_description($this->doc->nodeValue('/activity/basiclti/organizationdescr'));
        $rt->set_vendor_url($this->doc->nodeValue('/activity/basiclti/organizationurl'));
        $this->store($rt, $outdir, $title);
        return true;
    }

}
