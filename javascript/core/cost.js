(function($) {

	var costMethods = {
		init : function(options) {
			var data = $(this).data("cost");
			options = options || {};

			if (!data) {
				$(this).data("cost", $.extend({
					stack : [],
					clear : true
				}, options));
				data = $(this).data("cost");
			}

			$(this).filter(".cost_wrapper").each(function() {
				var cost = $(this);
				var numberWrapperElement = cost.find(".cost_number_wrapper");
				var costInputElement = cost.find("input.cost_number_input");
				var costSumElement = cost.find("input.cost_number_sum");
				var costTempElement = cost.find(".cost_number_temp");
				var creditKeyElement = cost.find(".method[data-cost-method=credit]");
				var singleKeyElement = cost.find(".method[data-cost-method=single]");
				var creditElement = creditKeyElement.find("input.entry_credit");
				var singleElement = singleKeyElement.find("input.entry_single");
				var sum = parseFloat(costSumElement.val()) || 0;

				// Number wrapper
				numberWrapperElement.unbind(".cost").bind("touchclick.cost", function(event){
					event.preventDefault();
					if (!$(event.target).is(costInputElement))
						costInputElement.focus();
				});
				numberWrapperElement.removeClass("selected");
				
				// Cost sum
				if (!sum)
					costSumElement.val("0");

				// Cost temp
				costTempElement.html("&nbsp;");

				// Cost input
				var costInputRegex = /[^0-9.]+/g;
				var costInputFunctionRegex = /([0-9.]+)([\/*\-+=]+)?/;
				var match = null, costInput = 0, $this = null, value = 0, key = 0;
				costInputElement.val(sum ? sum : "").attr("placeholder", sum).unbind(".cost").bind("keyup.cost", function(event) {
					event.stopPropagation();
					$this = $(this);
					value = $this.val();
					key = event.keyCode || event.which;					
					match = costInputFunctionRegex.exec(value);
					costInput = parseFloat(value) || 0;
					
					// Function
					if (match && match[2]) {
						cost.cost("function", match[2]);
					}
					// Enter
					else if (key === 13)
						cost.cost("function", "equal");
					// Escape
					else if (key === 27)
						cost.cost("method", "clear");
					// Legal characteres
					else
						$this.val(value.replace(costInputRegex, ""));
					// Set cost sum
					if (data.clear) {
						costSumElement.val(costInput);
						$this.attr("placeholder", costInput);
					}

					// $(this).val($(this).val().replace(/[^0-9.]+/g, ""));
					// if (!event.data.data.func) {
					// var val = parseFloat($(this).val());
					// costSumElement.val(!isNaN(val) ? val : "0");
					// }
					// $("[data-cost-number=2]").addClass("touching").delay(200).queue(function(next){$(this).removeClass("touching");
					// next();});
				}).focus(function(){
					numberWrapperElement.addClass("selected");					
				}).blur(function(){
					numberWrapperElement.removeClass("selected");
				});

				// Calculator
				cost.find(".cost_calculator_wrapper").unbind(".cost").bind("touchclick.cost", function(event) {
					event.preventDefault();
					var key = $(event.target);

					if (key.hasClass("method")) {
						cost.cost("method", key.attr("data-cost-method"));
					} else if (key.hasClass("number")) {
						cost.cost("number", key.attr("data-cost-number"));
					} else if (key.hasClass("function")) {
						cost.cost("function", key.attr("data-cost-function"));
					}
				});

				cost.find(".cost_calculator_wrapper .number,.cost_calculator_wrapper .function,.cost_calculator_wrapper .method").touchActive();
				
				// Credit/single
				creditKeyElement.attr("data-credit", creditElement.is(":checked") ? "credit" : "debit");
				singleKeyElement.attr("data-single", singleElement.is(":checked") ? "single" : "divide");
			});
		},
		method : function(method) {
			var cost = $(this);
			var data = $(this).data("cost");
			var costSumElement = cost.find("input.cost_number_sum");
			var costInputElement = cost.find("input.cost_number_input");
			var costTempElement = cost.find(".cost_number_temp");
			var creditKeyElement = cost.find(".method[data-cost-method=credit]");
			var singleKeyElement = cost.find(".method[data-cost-method=single]");
			var creditElement = creditKeyElement.find("input.entry_credit");
			var singleElement = singleKeyElement.find("input.entry_single");
			var costSum = parseFloat(costSumElement.val());
			var costInput = costInputElement.val();

			switch (method) {
			case "clear":
				costSumElement.val("0");
				costTempElement.html("&nbsp;");
				costInputElement.val("").attr("placeholder", "0");
				data.stack = [];
				data.clear = true;
				break;
			case "back":
				if (costInput) {
					costInputElement.val(costInput.substr(0, costInput.length - 1));
					costInput = costInputElement.val();
				}
				if (data.clear) {
					costSumElement.val(parseFloat(costInput) || 0);
					costInputElement.attr("placeholder", parseFloat(costInput) || 0);
				}
				break;
			case "credit":
				creditElement.prop("checked", !creditElement.is(":checked"));
				creditKeyElement.attr("data-credit", creditElement.is(":checked") ? "credit" : "debit");
				break;
			case "single":
				singleElement.prop("checked", !singleElement.is(":checked"));
				singleKeyElement.attr("data-single", singleElement.is(":checked") ? "single" : "divide");
				break;
			}
		},
		"function" : function(func) {
			var cost = $(this);
			var data = $(this).data("cost");
			var costSumElement = cost.find("input.cost_number_sum");
			var costInputElement = cost.find("input.cost_number_input");
			var costTempElement = cost.find(".cost_number_temp");
			var inputSum = parseFloat(costInputElement.val()) || 0;
			var costSum = parseFloat(costSumElement.val()) || inputSum;
			var isCostInputEmpty = costInputElement.val() == "";
			var isEqual = false;
			var funcSign = "";
			data.clear = false;

			// Function
			switch (func) {
			case "/":
			case "divide":
				funcSign = "/";
				break;
			case "*":
			case "multiply":
				funcSign = "*";
				break;
			case "+":
			case "addition":
				funcSign = "+";
				break;
			case "-":
			case "substract":
				funcSign = "-";
				break;
			case "=":
			case "equal":
				funcSign = "";
				isEqual = true;
				break;
			default:
				return;
			}

			// Push input sum & sign
			if (isCostInputEmpty && data.stack.length > 0)
				data.stack[data.stack.length - 1] = funcSign;
			else {
				data.stack.push(inputSum);
				data.stack.push(funcSign);
			}
			
			// Evaluate
			var evaluate = data.stack.join("").replace(/[^0-9]$/, '');

			// Cost temp
			costTempElement.text(data.stack.join(" "));

			// Cost sum
			costSum = eval(evaluate);
			if (costSum == Infinity)
				costSum = 0;
			costSumElement.val(costSum);

			// Cost input
			costInputElement.val("").attr("placeholder", costSum);

			// Equal
			if (isEqual) {
				data.stack = [];
				data.clear = true;
				costSumElement.val(costSum);
				costInputElement.val(costSum);
				costTempElement.html("&nbsp;");
				if (data.equalCallback)
					data.equalCallback();
			}
		},
		number : function(number) {
			var cost = $(this);
			var data = $(this).data("cost");
			var costSumElement = cost.find("input.cost_number_sum");
			var costInputElement = cost.find("input.cost_number_input");

			switch (number) {
			case "period":
				if (costInputElement.val().indexOf(".") == -1) {
					costInputElement.val((costInputElement.val().length == 0 ? "0" : costInputElement.val()) + ".");
				}
				break;
			default:
				costInputElement.val(costInputElement.val() + number);
				break;
			}

			var costInput = parseFloat(costInputElement.val()) || 0;
			if (data.clear) {
				costSumElement.val(costInput);
				costInputElement.attr("placeholder", costInput); 
			}
		}
	};

	$.fn.cost = function(method) {

		if (costMethods[method]) {
			return costMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return costMethods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.cost');
		}

	};

})(jQuery);