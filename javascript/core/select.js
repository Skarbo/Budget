(function($) {

	var selectMethods = {
		init : function(options) {
			var data = $(this).data("select");
			options = options || {};

			if (!data) {
				$(this).data("select", {
					options : options
				});
			}

			$(this).filter(".select_wrapper").each(function() {
				var element = $(this);

				element.find(".select_container").empty();
				for ( var i in options.options) {
					element.select("add", options.options[i]);
				}

				element.unbind(".select").bind("touchclick.select", {
					select : element
				}, function(event) {
					var selectValue = $(event.target).closest(".select_select").find(".select_radio input[type=radio]");
					event.data.select.select("select", selectValue.val(), true);
				});
				
				element.find(".select_select").touchActive();

				element.find(".select_new .select_for input[type=text]").val("").unbind(".select").bind("touchclick.select", function(event) {
					event.stopPropagation();
				}).bind("keyup.select", {
					select : element
				}, function(event) {
					var key = event.keyCode || event.which;
					if (key === 13) {
						event.data.select.select("select", "_new", $(this).val() != "");
						return true;
					}
					return false;
				});
				
				if (options.selected)
					element.select("select", options.selected);
			});
		},
		add : function(select) {
			var element = $(this);
			var selectTemplate = element.find(".select_template .select_select").clone();

			selectTemplate.find(".select_radio input[type=radio]").val(select.value);
			selectTemplate.find(".select_for").html(select.text);
			element.find(".select_container").append(selectTemplate);
		},
		select : function(value, isCallback) {
			var element = $(this), data = element.data("select");
			var radio = element.find(".select_select .select_radio input[type=radio][value=\"" + value + "\"]");
			var newInput = element.find(".select_new .select_for input:first-child");
			if (radio.length == 0)
				return;
			radio.prop("checked", true);
			element.find(".select_select").removeClass("selected");
			radio.closest(".select_select").addClass("selected");
			if (value == "_new" && newInput.val() == "") {
				isCallback = false;
				newInput.focus();
			}
			if (isCallback && data.options.selectCallback)
				data.options.selectCallback(value);
		}
	};

	$.fn.select = function(method) {

		if (selectMethods[method]) {
			return selectMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return selectMethods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.select');
		}

	};

})(jQuery);