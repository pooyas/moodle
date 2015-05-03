
/**
 * Javascript helper function for Folder module
 *
 * @package    mod
 * @subpackage folder
 * @copyright  2009 Petr Skoda  
 * 
 */

M.mod_folder = {};

M.mod_folder.init_tree = function(Y, id, expand_all) {
    Y.use('yui2-treeview', function(Y) {
        var tree = new Y.YUI2.widget.TreeView(id);

        tree.subscribe("clickEvent", function(node, event) {
            // we want normal clicking which redirects to url
            return false;
        });

        if (expand_all) {
            tree.expandAll();
        } else {
            // Else just expand the top node.
            tree.getRoot().children[0].expand();
        }

        tree.render();
    });
}
