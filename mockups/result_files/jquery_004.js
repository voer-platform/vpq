// jQuery Plugin Paging
// A boilerplate for jumpstarting jQuery plugins development
// version 1.0, Nov 18th, 2014
// by Huy Vu
// remember to change every instance of "simplePaging" to the name of your plugin!
(function($) {
    // here we go!
    $.simplePaging = function(element, options) {
        // plugin's default options
        // this is private property and is accessible only from inside the plugin
        var defaults = {
            pageSize: 10,
            currentPage: 1,
            holder: null,
            pagerLocation: "after",
            // if your plugin is event-driven, you may provide callback capabilities
            // for its events. execute these functions before or after events of your
            // plugin, so that users may customize those particular events without
            // changing the plugin's code
            onFoo: function() {}
        }
        // to avoid confusions, use "plugin" to reference the
        // current instance of the object
        var plugin = this;
        // this will hold the merged default, and user-provided options
        // plugin's properties will be available through this object like:
        // plugin.settings.propertyName from inside the plugin or
        // element.data('simplePaging').settings.propertyName from outside the plugin,
        // where "element" is the element the plugin is attached to;
        plugin.settings = {}
        var $element = $(element), // reference to the jQuery version of DOM element
            element = element; // reference to the actual DOM element

        var pageCounter = 1;
        // the "constructor" method that gets called when the object is created
        plugin.init = function() {
            // the plugin's final properties are the merged default and
            // user-provided options (if any)
            plugin.settings = $.extend({}, defaults, options);
            // code goes here

            var selector = $element;
            selector.wrap("<div class='simplePagerContainer'></div>");
            selector.parents(".simplePagerContainer").find("ul.simplePagerNav").remove();
            selector.children().each(function(i) {
                if (i < pageCounter * plugin.settings.pageSize && i >= (pageCounter - 1) * plugin.settings.pageSize) {
                    $(this).addClass("simplePagerPage" + pageCounter);
                } else {
                    $(this).addClass("simplePagerPage" + (pageCounter + 1));
                    pageCounter++;
                }
            });
            selector.children().hide();
            selector.children(".simplePagerPage" + plugin.settings.currentPage).show();
            if (pageCounter <= 1) {
                return;
            }
            var pageNav = "<ul class='simplePagerNav pagination'>";
            pageNav += "<li class='previous'><a href='#' rel='previous'>«</a></li>";
            for (i = 1; i <= pageCounter; i++) {
                if (i == plugin.settings.currentPage) {
                    pageNav += "<li class='active simplePageNav" + i + "'><a rel='" + i + "' href='#'>" + i + "</a></li>";
                } else {
                    pageNav += "<li class='simplePageNav" + i + "'><a rel='" + i + "' href='#'>" + i + "</a></li>";
                }
            }
            pageNav += "<li class='next'><a href='#' rel='next'>»</a></li>";
            pageNav += "</ul>";
            if (!plugin.settings.holder) {
                switch (plugin.settings.pagerLocation) {
                    case "before":
                        selector.before(pageNav);
                        break;
                    case "both":
                        selector.before(pageNav);
                        selector.after(pageNav);
                        break;
                    default:
                        selector.after(pageNav);
                }
            } else {
                $(plugin.settings.holder).append(pageNav);
            }
            selector.parent().find(".simplePagerNav a").click(function() {
                var clickedLink = $(this).attr("rel");
                var iNextPage = 0;
                if (clickedLink == 'previous' || clickedLink == 'next'){
                    if (clickedLink == 'next'){
                        iNextPage = plugin.settings.currentPage < pageCounter ? plugin.settings.currentPage + 1 : plugin.settings.currentPage;
                    }else{
                        iNextPage = plugin.settings.currentPage > 1 ? plugin.settings.currentPage - 1 : plugin.settings.currentPage;
                    }
                }else{
                    iNextPage = parseInt(clickedLink);
                }
                plugin.settings.currentPage = parseInt(iNextPage);
                if (plugin.settings.holder) {
                    $(this).parent("li").parent("ul").parent(plugin.settings.holder).find("li.active").removeClass("active");
                    $(this).parent("li").parent("ul").parent(plugin.settings.holder).find("a[rel='" + iNextPage + "']").parent("li").addClass("active");
                } else {
                    $(this).parent("li").parent("ul").parent(".simplePagerContainer").find("li.active").removeClass("active");
                    $(this).parent("li").parent("ul").parent(".simplePagerContainer").find("a[rel='" + iNextPage + "']").parent("li").addClass("active");
                }
                selector.children().hide();
                selector.find(".simplePagerPage" + iNextPage).show();
                return false;
            });
        }
        // public methods
        // these methods can be called like:
        // plugin.methodName(arg1, arg2, ... argn) from inside the plugin or
        // element.data('simplePaging').publicMethod(arg1, arg2, ... argn) from outside
        // the plugin, where "element" is the element the plugin is attached to;
        // a public method. for demonstration purposes only - remove it!
        plugin.nextPage = function() {
            var selector = $element;
            var iNextPage = plugin.settings.currentPage < pageCounter ? plugin.settings.currentPage + 1 : plugin.settings.currentPage;
            plugin.settings.currentPage = iNextPage;
            if (plugin.settings.holder) {
                $(plugin.settings.holder).find("li.active").removeClass("active");
                $(plugin.settings.holder).find("a[rel='" + iNextPage + "']").parent("li").addClass("active");
            } else {
                $(".simplePagerContainer").find("li.active").removeClass("active");
                $(".simplePagerContainer").find("a[rel='" + iNextPage + "']").parent("li").addClass("active");
            }
            selector.children().hide();
            selector.find(".simplePagerPage" + iNextPage).show();
            return false;
        }
        // private methods
        // these methods can be called only from inside the plugin like:
        // methodName(arg1, arg2, ... argn)
        // a private method. for demonstration purposes only - remove it!
        var foo_private_method = function() {
            // code goes here
        }
        // fire up the plugin!
        // call the "constructor" method
        plugin.init();
    }
    // add the plugin to the jQuery.fn object
    $.fn.simplePaging = function(options) {
        // iterate through the DOM elements we are attaching the plugin to
        return this.each(function() {
            // if plugin has not already been attached to the element
            if (undefined == $(this).data('simplePaging')) {
                // create a new instance of the plugin
                // pass the DOM element and the user-provided options as arguments
                var plugin = new $.simplePaging(this, options);
                // in the jQuery version of the element
                // store a reference to the plugin object
                // you can later access the plugin and its methods and properties like
                // element.data('simplePaging').publicMethod(arg1, arg2, ... argn) or
                // element.data('simplePaging').settings.propertyName
                $(this).data('simplePaging', plugin);
            }
        });
    }
})(jQuery);