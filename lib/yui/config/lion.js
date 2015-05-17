

// A module name should be composed of:
// lion-<component>-<module>[-<submodule>][-skin]
var parts = me.name.replace(/^lion-/,'').split('-'),
    component = parts.shift(),
    module = parts[0],
    min = '-min';

if (/-(skin|core)$/.test(me.name)) {
    // For these types, we need to remove the final word and set the type.
    parts.pop();
    me.type = 'css';

    // CSS is not minified - clear the min option.
    min = '';
}

if (module) {
    // Determine the filename based on the remaining parts.
    var filename = parts.join('-');

    // Build the first part of the filename.
    me.path = component + '/' + module + '/' + filename + min + '.' + me.type;
} else {
    // This is a hangup from the old ways of writing Modules.
    // We will start to warn about this once we have removed all core components of this form.
    me.path = component + '/' + component + '.' + me.type;
}
