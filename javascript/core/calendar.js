(function($) {

	var calendarMethods = {
		init : function(options) {
			var data = $(this).data("calendar");
			options = options || {};

			if (!data) {
				$(this).data("calendar", {
					options : options
				});
			}

			return this.each(function() {
				var calendar = $(this), dateOriginal = options.date;

				var calendarInputDate = calendar.find("input.calendar_date");
				if (calendarInputDate.length > 0) {
					if (calendarInputDate.val() && !isNaN(Date.parse(calendarInputDate.val())))
						dateOriginal = new Date(Date.parse(calendarInputDate.val()));
				} else {
					calendarInputDate = $("<input />", {
						"class" : "calendar_date"
					});
					calendar.append(calendarInputDate);
				}

				if (dateOriginal)
					calendarInputDate.val(dateOriginal.format("yyyy-mm-dd"));

				calendar.find(".calendar .calendar_weeks_wrapper").unbind(".calendar").bind("touchclick.calendar", {
					calendar : calendar
				}, function(event) {
					event.preventDefault();
					var calendarDate = $(event.target).attr("data-calendar-date");
					if (calendarDate) {
						event.data.calendar.calendar("select", new Date(Date.parse(calendarDate)));
					}
				});
				calendar.find(".calendar_month_prev, .calendar_month_next").unbind(".calendar").bind("touchclick.calendar", {
					calendar : calendar
				}, function(event) {
					event.preventDefault();
					event.data.calendar.calendar("month", $(event.target).hasClass("calendar_month_prev") ? "prev" : "next");
				}).touchActive();
				calendar.find(".calendar_day").touchActive();

				$(this).calendar("date", dateOriginal || new Date());
			});
		},
		date : function(date) {
			var calendar = $(this);

			var calendarInputDate = calendar.find("input.calendar_date");
			var dateOriginal = (new Date(Date.parse(calendarInputDate.val())));
			dateOriginal = !isNaN(dateOriginal) ? dateOriginal : null; 

			var dateFirst = new Date(date.getFullYear(), date.getMonth(), 1);
			var dayFirst = dateFirst.getDay();

			calendar.attr("data-calendar-date", date.format("yyyy-mm-dd"));
			calendar.find(".calendar_monthyear .month").text(date.format("mmmm"));			
			calendar.find(".calendar_monthyear .year").text(date.format("yyyy"));			

			var element = dayDate = lastWeek = null;
			calendar.find(".calendar .calendar_weeks_wrapper .calendar_week_wrapper .calendar_day").each(function(i) {
				element = $(this);
				dayDate = new Date(date.getFullYear(), date.getMonth(), (i + 2) - dayFirst);
				element.removeClass("selected");
				if (dayDate.getMonth() == date.getMonth()) {
					element.attr("data-calendar-date", dayDate.format("yyyy-mm-dd")).text(dayDate.getDate());
					lastWeek = parseInt(element.attr("data-calendar-week"));
					if (dateOriginal && dateOriginal.format("yyyy-mm-dd") == dayDate.format("yyyy-mm-dd"))
						element.addClass("selected");
				} else {
					element.attr("data-calendar-date", "").html("&nbsp;");
				}
			});

			calendar.find(".calendar .calendar_weeks_wrapper .calendar_week_wrapper").filter(function(i) {
				return i >= lastWeek;
			}).addClass("hide");
		},
		month : function(type) {
			var calendar = $(this);
			var date = new Date(Date.parse(calendar.attr("data-calendar-date")));
			var dateNew = new Date(date.getFullYear(), type == "prev" ? date.getMonth() - 1 : date.getMonth() + 1, 1);
			calendar.calendar("date", dateNew);
		},
		select : function(date) {
			var calendar = $(this), data = calendar.data("calendar");
			calendar.find("input.calendar_date").val(date.format("yyyy-mm-dd")).change();
			if (data.options.selectCallback)
				data.options.selectCallback(date);
			calendar.calendar("date", date);
		}
	};

	$.fn.calendar = function(method) {

		if (calendarMethods[method]) {
			return calendarMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return calendarMethods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.calendar');
		}

	};

})(jQuery);