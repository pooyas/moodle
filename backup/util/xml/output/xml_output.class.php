<?php



/**
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */

/**
 * This abstract class outputs XML contents provided by @xml_writer
 *
 * Contains the common functionalities for all the xml_output_xxx classes
 * and the interface for them. Mainly it's in charge of:
 *   - Initialize the corresponding stream/handler (file, DB connection...)
 *   - Finalize the stream/handler
 *   - Provide one common buffer for all output implementations
 *   - Receive XML contents from the @xml_writer and output them
 *   - Some basic throughtput stats
 *
 * TODO: Finish phpdocs
 */
abstract class xml_output {

    const DEFAULT_BUFFER_SIZE = 4096; // Use a default buffer size of 4K

    protected $inittime;  // Initial microtime
    protected $sentbytes; // Bytes sent to output

    protected $usebuffer; // Boolean to specify if output supports buffer (true) or no (false)
    protected $buffersize;// Size, in bytes, of the buffer.
    protected $currentbuffer;    // Buffer contents
    protected $currentbuffersize;// Current buffer size

    protected $running; // To know if output is running

    public function __construct($usebuffer = true) {
        $this->inittime   = microtime(true);
        $this->finishtime = $this->inittime;
        $this->sentbytes  = 0;

        $this->usebuffer         = $usebuffer;
        $this->buffersize        = $this->usebuffer ? self::DEFAULT_BUFFER_SIZE : 0;

        $this->running = null;
    }

    public function set_buffersize($buffersize) {
        if ($this->running) {
            throw new xml_output_exception('xml_output_already_started');
        }
        if (!$this->usebuffer) {
            throw new xml_output_exception('xml_output_buffer_nosupport');
        }
        // TODO: check it is integer > 0
        $this->buffersize = $buffersize;
    }

    public function start() {
        if ($this->running === true) {
            throw new xml_output_exception('xml_output_already_started');
        }
        if ($this->running === false) {
            throw new xml_output_exception('xml_output_already_stopped');
        }
        $this->inittime  = microtime(true);
        $this->sentbytes = 0;
        $this->running = true;
        $this->currentbuffer     = '';
        $this->currentbuffersize = 0;
        $this->init();
    }

    public function stop() {
        if (!$this->running) {
            throw new xml_output_exception('xml_output_not_started');
        }
        $this->finishtime = microtime(true);
        if ($this->usebuffer && $this->currentbuffersize > 0) { // Have pending contents in buffer
            $this->send($this->currentbuffer); // Send them
            $this->currentbuffer = '';
            $this->currentbuffersize = 0;
        }
        $this->running = false;
        $this->finish();
    }

    /**
     * Get contents from @xml_writer and buffer/output them
     */
    public function write($content) {
        if (!$this->running) {
            throw new xml_output_exception('xml_output_not_started');
        }
        $lenc = strlen($content); // Get length in bytes
        if ($lenc == 0) { // 0 length contents, nothing to do
            return;
        }
        // Buffer handling if available
        $tooutput = true; // By default, perform output
        if ($this->usebuffer) { // Buffer
            $this->currentbuffer .= $content;
            $this->currentbuffersize += $lenc;
            if ($this->currentbuffersize < $this->buffersize) {
                $tooutput = false; // Still within the buffer, don't output
            } else {
                $content = $this->currentbuffer; // Prepare for output
                $lenc = $this->currentbuffersize;
                $this->currentbuffer = '';
                $this->currentbuffersize = 0;
            }
        }
        // Output
        if ($tooutput) {
            $this->send($content); // Efectively send the contents
            $this->sentbytes += $lenc;
        }
    }

    public function debug_info() {
        if ($this->running !== false) {
            throw new xml_output_exception('xml_output_not_stopped');
        }
        return array('memory' => memory_get_peak_usage(true),
                     'time'   => $this->finishtime - $this->inittime,
                     'sent'   => $this->sentbytes);
    }

// Implementable API starts here

    abstract protected function init();

    abstract protected function finish();

    abstract protected function send($content);
}

/*
 * Exception class used by all the @xml_output stuff
 */
class xml_output_exception extends lion_exception {

    public function __construct($errorcode, $a=NULL, $debuginfo=null) {
        parent::__construct($errorcode, 'error', '', $a, null, $debuginfo);
    }
}
