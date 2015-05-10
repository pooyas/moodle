<?php


/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 * Based off of a template
 *
 * @package    mod
 * @subpackage assignment
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Assignment conversion handler
 */
class lion1_mod_assignment_handler extends lion1_mod_handler {

    /** @var lion1_file_manager */
    protected $fileman = null;

    /** @var int cmid */
    protected $moduleid = null;

    /** @var string current subplugin being processed*/
    private $currentsubpluginname = null;

    /** @var array of a lion1_assignment_[subplugin_name]_handler instances */
    private $subpluginhandlers = null;

    /**
     * Declare the paths in lion.xml we are able to convert
     *
     * The method returns list of {@link convert_path} instances.
     * For each path returned, the corresponding conversion method must be
     * defined.
     *
     * Note that the path /LION_BACKUP/COURSE/MODULES/MOD/ASSIGNMENT does not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {
        return array(
            new convert_path(
                'assignment', '/LION_BACKUP/COURSE/MODULES/MOD/ASSIGNMENT',
                array(
                    'renamefields' => array(
                        'description' => 'intro',
                        'format' => 'introformat',
                    )
                )
            )
            //@todo process user data
            //new convert_path('assignment_submission', '/LION_BACKUP/COURSE/MODULES/MOD/ASSIGNMENT/SUBMISSIONS/SUBMISSION')
        );
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/ASSIGNMENT
     * data available
     */
    public function process_assignment($data) {
        global $CFG;

        // get the course module id and context id
        $instanceid     = $data['id'];
        $cminfo         = $this->get_cminfo($instanceid);
        $this->moduleid = $cminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $this->moduleid);

        //store assignment type for possible subplugin conversions.
        $this->currentsubpluginname = $data['assignmenttype'];

        // get a fresh new file manager for this instance
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_assignment');

        // convert course files embedded into the intro
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $this->fileman);

        // convert the introformat if necessary
        if ($CFG->texteditors !== 'textarea') {
            $data['intro'] = text_to_html($data['intro'], false, false, true);
            $data['introformat'] = FORMAT_HTML;
        }

        // start writing assignment.xml
        $this->open_xml_writer("activities/assignment_{$this->moduleid}/assignment.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $this->moduleid,
            'modulename' => 'assignment', 'contextid' => $contextid));
        $this->xmlwriter->begin_tag('assignment', array('id' => $instanceid));

        foreach ($data as $field => $value) {
            if ($field <> 'id') {
                $this->xmlwriter->full_tag($field, $value);
            }
        }

        //after writing the assignment type element, let the subplugin add on whatever it wants.
        $this->handle_assignment_subplugin($data);

        $this->xmlwriter->begin_tag('submissions');

        return $data;
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/ASSIGNMENT/SUBMISSIONS/SUBMISSION
     * data available
     */
    public function process_assignment_submission($data) {
        //@todo process user data
        //$this->write_xml('submission', $data, array('/submission/id'));
    }

    /**
     * This handles calls to subplugin conversion classes.
     * called from <ASSIGNMENTTYPE> within process_assignment()
     */
    public function handle_assignment_subplugin($data) {
        $handler = $this->get_subplugin_handler($this->currentsubpluginname);
        $this->log('Instantiated assignment subplugin handler for '.$this->currentsubpluginname.'.', backup::LOG_DEBUG);
        $handler->use_xml_writer($this->xmlwriter);

        $this->log('Processing assignment subplugin handler callback for '.$this->currentsubpluginname.'.', backup::LOG_DEBUG);
        $handler->append_subplugin_data($data);
    }

    /**
     * This is executed when we reach the closing </MOD> tag of our 'assignment' path
     */
    public function on_assignment_end() {
        // finish writing assignment.xml
        $this->xmlwriter->end_tag('submissions');
        $this->xmlwriter->end_tag('assignment');
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // write inforef.xml
        $this->open_xml_writer("activities/assignment_{$this->moduleid}/inforef.xml");
        $this->xmlwriter->begin_tag('inforef');
        $this->xmlwriter->begin_tag('fileref');
        foreach ($this->fileman->get_fileids() as $fileid) {
            $this->write_xml('file', array('id' => $fileid));
        }
        $this->xmlwriter->end_tag('fileref');
        $this->xmlwriter->end_tag('inforef');
        $this->close_xml_writer();
    }

    /// internal implementation details follow /////////////////////////////////

    /**
     * Factory method returning the handler of the given assignment subplugin
     *
     * @param string $subplugin the name of the subplugin
     * @throws lion1_convert_exception
     * @return lion1_assignment_subplugin_handler the instance of the handler
     */
    protected function get_subplugin_handler($subplugin) {
        global $CFG; // we include other files here

        if (is_null($this->subpluginhandlers)) {
            $this->subpluginhandlers = array();
            $subplugins = core_component::get_plugin_list('assignment');
            foreach ($subplugins as $name => $dir) {
                $handlerfile  = $dir.'/backup/lion1/lib.php';
                $handlerclass = "lion1_mod_assignment_{$name}_subplugin_handler";
                if (!file_exists($handlerfile)) {
                    continue;
                }
                require_once($handlerfile);

                if (!class_exists($handlerclass)) {
                    throw new lion1_convert_exception('missing_handler_class', $handlerclass);
                }
                $this->log('preparing assignment subplugin handler', backup::LOG_DEBUG, $handlerclass);
                $this->subpluginhandlers[$name] = new $handlerclass($this, $name);
                if (!$this->subpluginhandlers[$name] instanceof lion1_assignment_subplugin_handler) {
                    throw new lion1_convert_exception('wrong_handler_class', get_class($this->subpluginhandlers[$name]));
                }
            }
        }

        if (!isset($this->subpluginhandlers[$subplugin])) {
            // Generic handling, prevents breaking conversion process...
            $this->subpluginhandlers[$subplugin] = new lion1_assignment_unsupported_subplugin_handler($this, $subplugin);
        }

        return $this->subpluginhandlers[$subplugin];
    }
}


/**
 * Base class for the assignment subplugin handler
 * Extend this for your own subplugin conversion handling purposes.
 */
abstract class lion1_assignment_subplugin_handler extends lion1_submod_handler {

    /**
     * @param lion1_mod_handler $assignmenthandler the handler of a module we are subplugin of
     * @param string $subpluginname the name of the subplugin
     */
    public function __construct(lion1_mod_handler $assignmenthandler, $subpluginname) {
        parent::__construct($assignmenthandler, 'assignment', $subpluginname);
    }

    /**
     * Provides a xml_writer instance to this assignment subplugin type handler
     *
     * @param xml_writer $xmlwriter
     */
    public function use_xml_writer(xml_writer $xmlwriter) {
        $this->xmlwriter = $xmlwriter;
    }

    /**
     * a call back (entry point) to the subplugin conversion handler class.
     * $data are the elements of <assignment>, any (@todo sub paths containing subplugindata isn't handed through).
     */

    public function append_subplugin_data($data) {
        // an example that does nothing - you'll do nothing if you don't overide it
        return false;

        //you will probably want to do stuff with $this->xmlwriter here (within your overridden method) to write plugin specific data.
    }
}

/**
 * This class handles subplugins that do not exist or that are not supported
 */
class lion1_assignment_unsupported_subplugin_handler extends lion1_assignment_subplugin_handler {
}
