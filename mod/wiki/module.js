

/**
 * Javascript helper function for wiki
 *
 */

M.mod_wiki = {};

M.mod_wiki.init = function(Y, args) {
    var WikiHelper = function(args) {
        WikiHelper.superclass.constructor.apply(this, arguments);
    }
    WikiHelper.NAME = "WIKI";
    WikiHelper.ATTRS = {
        options: {},
        lang: {}
    };
    Y.extend(WikiHelper, Y.Base, {
        initializer: function(args) {
        }
    });
    new WikiHelper(args);
};
M.mod_wiki.renew_lock = function() {
    var args = {
        sesskey: M.cfg.sesskey,
        pageid: wiki.pageid
    };
    if (wiki.section) {
        args.section = wiki.section;
    }
    YUI().use('io', function(Y) {
        function renewLock() {
            Y.io('lock.php?' + build_querystring(args), {
                method: 'POST'
            });
        }
        setInterval(renewLock, wiki.renew_lock_timeout * 1000);
    });
};
M.mod_wiki.history = function(Y, args) {
    var compare = false;
    var comparewith = false;
    var radio  = document.getElementsByName('compare');
    var radio2 = document.getElementsByName('comparewith');
    for(var i=0; i<radio.length;i++){
          if(radio[i].checked){
            compare = true;
        }
        if(!comparewith){
            radio[i].disabled=true;
            radio2[i].disabled=false;
        } else if(!compare && comparewith){
            radio[i].disabled=false;
            radio2[i].disabled=false;
        } else {
            radio[i].disabled=false;
            radio2[i].disabled=true;
        }

        if(radio2[i].checked){
            comparewith = true;
        }
    }
}

M.mod_wiki.deleteversion = function(Y, args) {
    var fromversion = false;
    var toversion = false;
    var radio  = document.getElementsByName('fromversion');
    var radio2 = document.getElementsByName('toversion');
    var length = radio.length;
    //version to should be more then version from
    for (var i = 0; i < radio.length; i++) {
        //if from-version is selected then disable all to-version options after that.
        if (fromversion) {
            radio2[i].disabled = true;
        } else {
            radio2[i].disabled = false;
        }
        //check when to-version option is selected
        if (radio2[i].checked) {
            toversion = true;
        }
        //make sure to-version should be >= from-version
        if (radio[i].checked) {
            fromversion = true;
            if (!toversion) {
                radio2[i].checked = true;
            }
        }
    }
    //avoid selecting first and last version
    if (radio[0].checked && radio2[length-1].checked) {
        radio2[length - 2].checked = true;
    } else if(radio[length - 1].checked && radio2[0].checked) {
        radio2[1].checked = true;
        radio2[0].disabled = true;
        toversion = true;
    }
}

M.mod_wiki.init_tree = function(Y, expand_all, htmlid) {
    Y.use('yui2-treeview', function(Y) {
        var tree = new Y.YUI2.widget.TreeView(htmlid);

        tree.subscribe("clickEvent", function(node, event) {
            // we want normal clicking which redirects to url
            return false;
        });

        if (expand_all) {
            tree.expandAll();
        }

        tree.render();
    });
};
