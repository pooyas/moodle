
/**
 * @package    tool_xmldb
 * @copyright  2003 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

// Register the needed events
onload=function() {
    // Adjust the form on load
    transformForm();

    // Get the required fields
    var typeField         = document.getElementById('menutype');

    // Register the rest of events
    if (typeField.addEventListener) {
        // Standard
        typeField.addEventListener('change', transformForm, false);
    } else {
        // IE 5.5
        typeField.attachEvent('onchange', transformForm);
    }
}

/**
 * This function controls all modifications to perform when any field changes
 */
function transformForm(event) {

    // Initialize all the needed variables
    var typeField         = document.getElementById('menutype');
    var fieldsField       = document.getElementById('fields');
    var reftableField     = document.getElementById('reftable');
    var reffieldsField    = document.getElementById('reffields');

    // Initially, enable everything
    typeField.disabled = false;
    fieldsField.disabled = false;
    reftableField.disabled = false;
    reffieldsField.disabled = false;

    // Based on type, disable some items
    switch (typeField.value) {
        case '1':  // XMLDB_KEY_PRIMARY
        case '2':  // XMLDB_KEY_UNIQUE
            reftableField.disabled = true;
            reftableField.value = '';
            reffieldsField.disabled = true;
            reffieldsField.value = '';
            break;
        case '3':  // XMLDB_KEY_FOREIGN
        case '5':  // XMLDB_KEY_FOREIGN_UNIQUE
            break;
    }
}
