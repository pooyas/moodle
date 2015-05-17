

/**
 */

// Register the needed events
onload=function() {
    // Adjust the form on load
    disablePopupHeads();
}

/**
 * This function disables some elements from the command and from the fields/keys/indexes drop downs
 */
function disablePopupHeads() {
    var popup = document.getElementById("menucommand");
    var i = popup.length;
    while (i--) {
        option = popup[i];
        if (option.value == "Fields" || option.value == "Keys" || option.value == "Indexes") {
            popup[i].disabled = true;
        }
    }
    popup = document.getElementById("menufieldkeyindex");
    i = popup.length;
    while (i--) {
        option = popup[i];
        if (option.value == "fieldshead" || option.value == "keyshead" || option.value == "indexeshead") {
            popup[i].disabled = true;
        }
    }
}
