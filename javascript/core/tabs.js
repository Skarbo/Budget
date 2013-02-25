(function($) {

	var tabsMethods = {
		init : function(options) {
			var data = $(this).data("tabs");
			options = options || {};

			if (!data) {
				$(this).data("tabs", {
					options : options
				});
			}
			
			var target = null, container = null, content = null, selected = null;
			$(this).filter(".tabs_wrapper").each(function(i, element) {
				target = $(element);
				container = target.find(".tabs_container");
				content = target.find(".tabs_content");
				selected = container.children().filter(".selected").attr("data-tab");
				if (!selected)
					selected = container.children().filter(":first-child").attr("data-tab");

				container.unbind(".tabs").bind("touchclick.tabs", {
					"tabs" : target
				}, function(event) {
					var tab = $(event.target).closest("[data-tab]").attr("data-tab");
					event.data.tabs.tabs("tab", tab, true);
				});
				
				var tabsCount = container.children().length; 
				container.children().css("width", (100/tabsCount).toFixed(2) + "%");

				// Select tab
				target.tabs("tab", selected);
				
				// Slider
				target.find(".tabs_container_wrapper").slider({
					'nohandle' : true
				});
			});
		},
		tab : function(tab, isCallback) {
			var data = $(this).data("tabs");
			var container = $(this).find(".tabs_container");
			var content = $(this).find(".tabs_content");

			if (container.children().filter("[data-tab=" + tab + "]").length == 0)
				return;

			container.children().removeClass("selected").filter("[data-tab=" + tab + "]").addClass("selected");
			content.find("[data-tab-content]").removeClass("selected").filter("[data-tab-content=" + tab + "]").addClass("selected");
			
			if (isCallback && data.options.selectCallback)
				data.options.selectCallback(tab);
			return $(this);
		},
		next : function() {			
			var container = $(this).find(".tabs_container");
			var tabSelected = container.children().filter(".selected[data-tab]");
			var tabNext = null;
			if (tabSelected.length > 0)
				tabNext = tabSelected.next();
			if (tabSelected.length == 0 || tabNext.length == 0)
				tabNext = container.children().filter(":first-child");
			if (tabNext.length > 0)
				$(this).tabs("tab", tabNext.attr("data-tab"), true);
			return $(this);
		},
		first : function() {			
			var container = $(this).find(".tabs_container");
			var tabNext = container.children().filter(":first-child");
			if (tabNext.length > 0)
				$(this).tabs("tab", tabNext.attr("data-tab"), true);
			return $(this);
		}
	};

	$.fn.tabs = function(method) {

		if (tabsMethods[method]) {
			return tabsMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return tabsMethods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.tabs');
		}

	};

})(jQuery);