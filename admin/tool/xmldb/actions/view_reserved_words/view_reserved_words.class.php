<?php

/**
 * @package    tool
 * @subpackage xmldb
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * This class will show all the reserved words in a format suitable to
 * be pasted to: http://docs.lion.org/en/XMLDB_reserved_words and
 * http://docs.lion.org/en/Database_reserved_words
 * Also, it introspects te DB looking for such words and informing about
 *
 */
class view_reserved_words extends XMLDBAction {

    /**
     * Init method, every subclass will have its own
     */
    function init() {
        parent::init();

        // Set own custom attributes
    $this->sesskey_protected = false; // This action doesn't need sesskey protection

        // Get needed strings
        $this->loadStrings(array(
            'listreservedwords' => 'tool_xmldb',
            'wrongreservedwords' => 'tool_xmldb',
            'table' => 'tool_xmldb',
            'field' => 'tool_xmldb',
            'back' => 'tool_xmldb'
        ));
    }

    /**
     * Invoke method, every class will have its own
     * returns true/false on completion, setting both
     * errormsg and output as necessary
     */
    function invoke() {
        parent::invoke();

        $result = true;

        // Set own core attributes
        $this->does_generate = ACTION_GENERATE_HTML;

        // These are always here
        global $CFG, $XMLDB, $DB;

        // Calculate list of available SQL generators
        require_once("$CFG->libdir/ddl/sql_generator.php");
        $reserved_words = sql_generator::getAllReservedWords();

        // Now, calculate, looking into current DB (with AdoDB Metadata), which fields are
        // in the list of reserved words
        $wronguses = array();
        $dbtables = $DB->get_tables();
        if ($dbtables) {
            foreach ($dbtables as $table) {
                if (array_key_exists($table, $reserved_words)) {
                    $wronguses[] = $this->str['table'] . ' - ' . $table . ' (' . implode(', ',$reserved_words[$table]) . ')';

                }
                $dbfields = $DB->get_columns($table);
                if ($dbfields) {
                    foreach ($dbfields as $dbfield) {
                        if (array_key_exists($dbfield->name, $reserved_words)) {
                            $wronguses[] = $this->str['field'] . ' - ' . $table . '->' . $dbfield->name . ' (' . implode(', ',$reserved_words[$dbfield->name]) . ')';
                        }
                    }
                }
            }
        }

        // Sort the wrong uses
        sort($wronguses);

        // The back to edit table button
        $b = ' <p class="centerpara buttons">';
        $b .= '<a href="index.php">[' . $this->str['back'] . ']</a>';
        $b .= '</p>';
        $o = $b;

        // The list of currently wrong field names
        if ($wronguses) {
            $o.= '    <table id="formelements" class="boxaligncenter" cellpadding="5">';
            $o.= '      <tr><td align="center"><font color="red">' . $this->str['wrongreservedwords'] . '</font></td></tr>';
            $o.= '      <tr><td>';
            $o.= '        <ul><li>' . implode('</li><li>', $wronguses) . '</li></ul>';
            $o.= '      </td></tr>';
            $o.= '    </table>';
        }

        // The textarea showing all the reserved words
        $o.= '    <table id="formelements" class="boxaligncenter" cellpadding="5">';
        $o.= '      <tr><td align="center">' . $this->str['listreservedwords'].'</td></tr>';
        $o.= '      <tr><td><textarea cols="80" rows="32">';
        $o.= s(implode(', ', array_keys($reserved_words)));
        $o.= '</textarea></td></tr>';
        $o.= '    </table>';

        $this->output = $o;

        // Launch postaction if exists (leave this here!)
        if ($this->getPostAction() && $result) {
            return $this->launch($this->getPostAction());
        }

        // Return ok if arrived here
        return $result;
    }
}

