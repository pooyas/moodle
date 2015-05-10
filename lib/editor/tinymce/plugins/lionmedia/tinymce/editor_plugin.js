/**
 * @author 2015 Pooya Saeedi
 */

(function() {
    var each = tinymce.each;

    tinymce.PluginManager.requireLangPack('lionmedia');

    tinymce.create('tinymce.plugins.LionmediaPlugin', {
        init : function(ed, url) {
            var t = this;

            t.editor = ed;
            t.url = url;

            // Register commands.
            ed.addCommand('mceLionMedia', function() {
                ed.windowManager.open({
                    file : url + '/lionmedia.htm',
                    width : 480 + parseInt(ed.getLang('media.delta_width', 0)),
                    height : 480 + parseInt(ed.getLang('media.delta_height', 0)),
                    inline : 1
                }, {
                    plugin_url : url
                });
            });

            // Register buttons.
            ed.addButton('lionmedia', {
                    title : 'lionmedia.desc',
                    image : url + '/img/icon.png',
                    cmd : 'mceLionMedia'});

        },

        _parse : function(s) {
            return tinymce.util.JSON.parse('{' + s + '}');
        },

        getInfo : function() {
            return {
                longname : 'Lion media',
                author : '2015 Pooya Saeedi',
                version : "1.0"
            };
        }

    });

    // Register plugin.
    tinymce.PluginManager.add('lionmedia', tinymce.plugins.LionmediaPlugin);
})();
