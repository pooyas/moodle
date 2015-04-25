<?php

/**
 * override permissions table.
 *
 * @package    core_role
 * @copyright  2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

class core_role_override_permissions_table_advanced extends core_role_capability_table_with_risks {
    protected $strnotset;
    protected $haslockedcapabilities = false;

    /**
     * Constructor.
     *
     * This method loads all the information about the current state of
     * the overrides, then updates that based on any submitted data. It also
     * works out which capabilities should be locked for this user.
     *
     * @param object $context the context this table relates to.
     * @param integer $roleid the role being overridden.
     * @param boolean $safeoverridesonly If true, the user is only allowed to override
     *      capabilities with no risks.
     */
    public function __construct($context, $roleid, $safeoverridesonly) {
        parent::__construct($context, 'overriderolestable', $roleid);
        $this->displaypermissions = $this->allpermissions;
        $this->strnotset = get_string('notset', 'core_role');

        // Determine which capabilities should be locked.
        if ($safeoverridesonly) {
            foreach ($this->capabilities as $capid => $cap) {
                if (!is_safe_capability($cap)) {
                    $this->capabilities[$capid]->locked = true;
                    $this->haslockedcapabilities = true;
                }
            }
        }
    }

    protected function load_parent_permissions() {
        // Get the capabilities from the parent context, so that can be shown in the interface.
        $parentcontext = $this->context->get_parent_context();
        $this->parentpermissions = role_context_capabilities($this->roleid, $parentcontext);
    }

    public function has_locked_capabilities() {
        return $this->haslockedcapabilities;
    }

    protected function add_permission_cells($capability) {
        $disabled = '';
        if ($capability->locked || $this->parentpermissions[$capability->name] == CAP_PROHIBIT) {
            $disabled = ' disabled="disabled"';
        }

        // One cell for each possible permission.
        foreach ($this->displaypermissions as $perm => $permname) {
            $strperm = $this->strperms[$permname];
            $extraclass = '';
            if ($perm != CAP_INHERIT && $perm == $this->parentpermissions[$capability->name]) {
                $extraclass = ' capcurrent';
            }
            $checked = '';
            if ($this->permissions[$capability->name] == $perm) {
                $checked = 'checked="checked" ';
            }
            echo '<td class="' . $permname . $extraclass . '">';
            echo '<label><input type="radio" name="' . $capability->name .
                '" value="' . $perm . '" ' . $checked . $disabled . '/> ';
            if ($perm == CAP_INHERIT) {
                $inherited = $this->parentpermissions[$capability->name];
                if ($inherited == CAP_INHERIT) {
                    $inherited = $this->strnotset;
                } else {
                    $inherited = $this->strperms[$this->allpermissions[$inherited]];
                }
                $strperm .= ' (' . $inherited . ')';
            }
            echo '<span class="note">' . $strperm . '</span>';
            echo '</label></td>';
        }
    }
}
