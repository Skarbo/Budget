(function($) {

	var editSettingsMethod = {
		init : function(options) {
			var data = $(this).data("editSettings");
			options = options || {};

			if (!data) {
				$(this).data("editSettings", options);
				data = $(this).data("editSettings");
			}

			$(this).filter(".edit_settings_wrapper").each(function() {
				var $this = $(this);

				$this.children().filter(".setting_wrapper.edit:NOT(.template)").remove();

				$this.unbind(".editSettings").bind("touchclick.editSettings", function(event) {
					event.preventDefault();
					var target = $(event.target);
					var settingElement = target.closest(".setting_wrapper");

					// Delete
					if (target.is(".button.delete") && data.deleteCallback) {
						data.deleteCallback(settingElement, function() {
							setTimeout(function() {
								settingElement.fadeOut({
									complete : function() {
										$(this).remove();
									}
								});
							}, 10);
						});
					}
					// New
					else if (target.is(".button.new") && data.newCallback) {
						if (data.newCallback(settingElement))
							settingElement.find("input").val("").blur();
					}
					// Edit
					else if (target.is(".button.edit") && data.editCallback) {
						if (data.editCallback(settingElement))
							settingElement.find("input").prop("disabled", true);
					}
				});
			});
		},
		add : function(add, easeIn) {
			var $this = $(this), data = $this.data("editSettings");
			var template = $this.find(".setting_wrapper.edit.template").clone().removeClass("template");

			if (data && data.addCallback)
				data.addCallback(add, template);

			$this.find(".setting_wrapper.new").before(template);
			$this.find(".button").touchActive();
		},
		"delete" : function(settingWrapper) {
			var $this = $(this), data = $this.data("editSettings");
			var template = $this.find(".setting_wrapper.edit.template").clone().removeClass("template");

			if (data.addCallback)
				data.addCallback(add, template);

			$this.find(".setting_wrapper.new").before(template);
			$this.find(".button").touchActive();
		},
		clear : function() {
			var $this = $(this);
			$this.find(".setting_wrapper.edit:NOT(.template)").empty();
			$this.find(".setting_wrapper.new input").val("");
		}
	};

	$.fn.editSettings = function(method) {

		if (editSettingsMethod[method]) {
			return editSettingsMethod[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return editSettingsMethod.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.editSettings');
		}

	};

})(jQuery);