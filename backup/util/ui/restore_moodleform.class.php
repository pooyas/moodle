<?php

/**
 * This file contains the forms used by the restore stages
 *
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

// Note:
// Renaming required

/**
 * An abstract moodleform class specially designed for the restore forms.
 *
 */
class restore_moodleform extends base_moodleform {
    /**
     * Constructor.
     *
     * Overridden just for the purpose of typehinting the first arg.
     *
     * @param restore_ui_stage $uistage
     * @param null $action
     * @param null $customdata
     * @param string $method
     * @param string $target
     * @param null $attributes
     * @param bool $editable
     */
    public function __construct(restore_ui_stage $uistage, $action = null, $customdata = null, $method = 'post',
                                $target = '', $attributes = null, $editable = true) {
        parent::__construct($uistage, $action, $customdata, $method, $target, $attributes, $editable);
    }
}

/**
 * Restore settings form.
 *
 */
class restore_settings_form extends restore_moodleform {}

/**
 * Restore schema review form.
 *
 */
class restore_schema_form extends restore_moodleform {}

/**
 * Restore complete process review form.
 *
 */
class restore_review_form extends restore_moodleform {};