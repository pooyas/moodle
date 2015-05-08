<?php

/**
 * New messaging class.
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

namespace core\message;

defined('LION_INTERNAL') || die();

/**
 * New messaging class.
 *
 * Required parameters of the $eventdata object:
 *  component string Component name. must exist in message_providers
 *  name string Message type name. must exist in message_providers
 *  userfrom object|int The user sending the message
 *  userto object|int The message recipient
 *  subject string The message subject
 *  fullmessage string The full message in a given format
 *  fullmessageformat int The format if the full message (FORMAT_LION, FORMAT_HTML, ..)
 *  fullmessagehtml string The full version (the message processor will choose with one to use)
 *  smallmessage string The small version of the message
 *
 * Optional parameters of the $eventdata object:
 *  notification bool Should the message be considered as a notification rather than a personal message
 *  contexturl string If this is a notification then you can specify a url to view the event.
 *                    For example the forum post the user is being notified of.
 *  contexturlname string The display text for contexturl.
 *  replyto string An email address which can be used to send an reply.
 *  attachment stored_file File instance that needs to be sent as attachment.
 *  attachname string Name of the attachment.
 *
 */
class message {
    /** @var string Component name. */
    private $component;

    /** @var string Name. */
    private $name;

    /** @var object|int The user who is sending this message. */
    private $userfrom;

    /** @var object|int The user who is receiving from which is sending this message. */
    private $userto;

    /** @var string Subject of the message. */
    private $subject;

    /** @var string Complete message. */
    private $fullmessage;

    /** @var int Message format. */
    private $fullmessageformat;

    /** @var string Complete message in html format. */
    private $fullmessagehtml;

    /** @var  string Smaller version of the message. */
    private $smallmessage;

    /** @var  int Is it a notification? */
    private $notification;

    /** @var  string context url. */
    private $contexturl;

    /** @var  string context name. */
    private $contexturlname;

    /** @var  string An email address which can be used to send an reply. */
    private $replyto;

    /** @var  int Used internally to store the id of the row representing this message in DB. */
    private $savedmessageid;

    /** @var  \stored_file  File to be attached to the message. Note:- not all processors support this.*/
    private $attachment;

    /** @var  string Name of the attachment. Note:- not all processors support this.*/
    private $attachname;

    /** @var array a list of properties that is allowed for each message. */
    private $properties = array('component', 'name', 'userfrom', 'userto', 'subject', 'fullmessage', 'fullmessageformat',
                                'fullmessagehtml', 'smallmessage', 'notification', 'contexturl', 'contexturlname', 'savedmessageid',
                                'replyto', 'attachment', 'attachname');

    /** @var array property to store any additional message processor specific content */
    private $additionalcontent = array();

    /**
     * Fullmessagehtml content including any processor specific content.
     *
     * @param string $processorname Name of the processor.
     *
     * @return mixed|string
     */
    protected function get_fullmessagehtml($processorname = '') {
        if (!empty($processorname) && isset($this->additionalcontent[$processorname])) {
            return $this->get_message_with_additional_content($processorname, 'fullmessagehtml');
        } else {
            return $this->fullmessagehtml;
        }
    }

    /**
     * Fullmessage content including any processor specific content.
     *
     * @param string $processorname Name of the processor.
     *
     * @return mixed|string
     */
    protected function get_fullmessage($processorname = '') {
        if (!empty($processorname) && isset($this->additionalcontent[$processorname])) {
            return $this->get_message_with_additional_content($processorname, 'fullmessage');
        } else {
            return $this->fullmessage;
        }
    }

    /**
     * Smallmessage content including any processor specific content.
     *
     * @param string $processorname Name of the processor.
     *
     * @return mixed|string
     */
    protected function get_smallmessage($processorname = '') {
        if (!empty($processorname) && isset($this->additionalcontent[$processorname])) {
            return $this->get_message_with_additional_content($processorname, 'smallmessage');
        } else {
            return $this->smallmessage;
        }
    }

    /**
     * Helper method used to get message content added with processor specific content.
     *
     * @param string $processorname Name of the processor.
     * @param string $messagetype one of 'fullmessagehtml', 'fullmessage', 'smallmessage'.
     *
     * @return mixed|string
     */
    protected function get_message_with_additional_content($processorname, $messagetype) {
        $message = $this->$messagetype;
        if (isset($this->additionalcontent[$processorname]['*'])) {
            // Content that needs to be added to all format.
            $pattern = $this->additionalcontent[$processorname]['*'];
            $message = empty($pattern['header']) ? $message : $pattern['header'] . $message;
            $message = empty($pattern['footer']) ? $message : $message . $pattern['footer'];
        }

        if (isset($this->additionalcontent[$processorname][$messagetype])) {
            // Content that needs to be added to the specific given format.
            $pattern = $this->additionalcontent[$processorname][$messagetype];
            $message = empty($pattern['header']) ? $message : $pattern['header'] . $message;
            $message = empty($pattern['footer']) ? $message : $message . $pattern['footer'];
        }

        return $message;
    }

    /**
     * Magic getter method.
     *
     * @param string $prop name of property to get.
     *
     * @return mixed
     * @throws \coding_exception
     */
    public function __get($prop) {
        if (in_array($prop, $this->properties)) {
            return $this->$prop;
        }
        throw new \coding_exception("Invalid property $prop specified");
    }

    /**
     * Magic setter method.
     *
     * @param string $prop name of property to set.
     * @param mixed $value value to assign to the property.
     *
     * @return mixed
     * @throws \coding_exception
     */
    public function __set($prop, $value) {
        if (in_array($prop, $this->properties)) {
            return $this->$prop = $value;
        }
        throw new \coding_exception("Invalid property $prop specified");
    }

    /**
     * This method lets you define content that would be added to the message only for specific message processors.
     *
     * Example of $content:-
     * array('fullmessagehtml' => array('header' => 'header content', 'footer' => 'footer content'),
     *       'smallmessage' => array('header' => 'header content for small message', 'footer' => 'footer content'),
     *       '*' => array('header' => 'header content for all types', 'footer' => 'footer content')
     * )
     *
     * @param string $processorname name of the processor.
     * @param array $content content to add in the above defined format.
     */
    public function set_additional_content($processorname, $content) {
        $this->additionalcontent[$processorname] = $content;
    }

    /**
     * Get a event object for a specific processor in stdClass format.
     *
     * @param string $processorname Name of the processor.
     *
     * @return \stdClass event object in stdClass format.
     */
    public function get_eventobject_for_processor($processorname) {
        // This is done for Backwards compatibility. We should consider throwing notices here in future versions and requesting
        // them to use proper api.

        $eventdata = new \stdClass();
        foreach ($this->properties as $prop) {
            $func = "get_$prop";
            $eventdata->$prop = method_exists($this, $func) ? $this->$func($processorname) : $this->$prop;
        }
        return $eventdata;
    }
}