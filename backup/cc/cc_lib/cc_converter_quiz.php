<?php

/**
 * @package    backup
 * @subpackage convert
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once('cc_converters.php');
require_once('cc_general.php');
require_once('cc_asssesment.php');
require_once('cc_assesment_truefalse.php');
require_once('cc_assesment_essay.php');
require_once('cc_assesment_sfib.php');

class cc_converter_quiz extends cc_converter {

    public function __construct(cc_i_item &$item, cc_i_manifest &$manifest, $rootpath, $path) {
        $this->cc_type     = cc_version11::assessment;
        $this->defaultfile = 'quiz.xml';
        $this->defaultname = assesment11_resurce_file::deafultname;
        parent::__construct($item, $manifest, $rootpath, $path);
    }

    public function convert($outdir) {
        $rt = new assesment11_resurce_file();
        $title = $this->doc->nodeValue('/activity/quiz/name');
        $rt->set_title($title);

        // Metadata.
        $metadata = new cc_assesment_metadata();
        $rt->set_metadata($metadata);
        $metadata->enable_feedback();
        $metadata->enable_hints();
        $metadata->enable_solutions();
        // Attempts.
        $max_attempts = (int)$this->doc->nodeValue('/activity/quiz/attempts_number');
        if ($max_attempts > 0) {
            // Qti does not support number of specific attempts bigger than 5 (??)
            if ($max_attempts > 5) {
                $max_attempts = cc_qti_values::unlimited;
            }
            $metadata->set_maxattempts($max_attempts);
        }
        // Time limit must be converted into minutes.
        $timelimit = (int)floor((int)$this->doc->nodeValue('/activity/quiz/timelimit') / 60);
        if ($timelimit > 0) {
            $metadata->set_timelimit($timelimit);
            $metadata->enable_latesubmissions(false);
        }

        $contextid = $this->doc->nodeValue('/activity/@contextid');
        $result = cc_helpers::process_linked_files( $this->doc->nodeValue('/activity/quiz/intro'),
                                                    $this->manifest,
                                                    $this->rootpath,
                                                    $contextid,
                                                    $outdir);
        cc_assesment_helper::add_assesment_description($rt, $result[0], cc_qti_values::htmltype);

        // Section.
        $section = new cc_assesment_section();
        $rt->set_section($section);

        // Process the actual questions.
        $ndeps = cc_assesment_helper::process_questions($this->doc,
                                                        $this->manifest,
                                                        $section,
                                                        $this->rootpath,
                                                        $contextid,
                                                        $outdir);
        if ($ndeps === false) {
            // No exportable questions in quiz or quiz has no questions
            // so just skip it.
            return true;
        }
        // Store any additional dependencies.
        $deps = array_merge($result[1], $ndeps);

        // Store everything.
        $this->store($rt, $outdir, $title, $deps);
        return true;
    }
}
