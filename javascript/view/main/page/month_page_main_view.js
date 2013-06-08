// CONSTRUCTOR
MonthPageMainView.prototype = new PageMainView();

function MonthPageMainView(view) {
	PageMainView.apply(this, arguments);
	this.entriesPresenter = new EntriesPresenterView(view);
	this.overviewPresenter = new OverviewMonthPresenterView(view);
	this.entries = {};
	this.monthId = null;
	this.month = {};
	this.chartApiLoad = false;
	this.chartLoad = false;
	this.chartDraw = false;
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BudgetMainView}
 */
MonthPageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

/**
 * @return {EntriesPresenterView}
 */
MonthPageMainView.prototype.getEntriesPresenter = function() {
	return this.entriesPresenter;
};

/**
 * @return {OverviewMonthPresenterView}
 */
MonthPageMainView.prototype.getOverviewPresenter = function() {
	return this.overviewPresenter;
};

// ... ... ELEMENT

MonthPageMainView.prototype.getTabsElement = function() {
	return this.getRoot().find(".tabs_wrapper");
};

MonthPageMainView.prototype.getEntriesWrapperElement = function() {
	return this.getRoot().find(".entries_wrapper");
};

MonthPageMainView.prototype.getOverviewWrapperElement = function() {
	return this.getRoot().find(".overview_wrapper");
};

MonthPageMainView.prototype.getChartWrapperElement = function() {
	return this.getRoot().find("#chart_month_wrapper");
};

// ... ... /ELEMENT

// ... /GET

// ... DO

MonthPageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// EVENTS

	// Handle "Chartload" event
	this.getController().getEventHandler().registerListener(ChartloadEvent.TYPE,
	/**
	 * @param {ChartloadEvent}
	 *            event
	 */
	function(event) {
		context.chartLoad = true;
		context.drawChart();
	});

	// Handle "Filter" event
	this.getController().getEventHandler().registerListener(FilterEvent.TYPE,
	/**
	 * @param {FilterEvent}
	 *            event
	 */
	function(event) {
		context.handleFilter(event.getOptions());
	});

	// Handle "Select" event
	this.getController().getEventHandler().registerListener(SelectEvent.TYPE,
	/**
	 * @param {SelectEvent}
	 *            event
	 */
	function(event) {
		if (event.getSelectType() == "month" && context.isVisible()) {
			console.log("Select month", event.getId());
			context.show(event.getId());
		}
	});

	// Handle "Resize" event
	this.getController().getEventHandler().registerListener(ResizeEvent.TYPE,
	/**
	 * @param {ResizeEvent}
	 *            event
	 */
	function(event) {
		if (context.isVisible()) {
			context.getTabsElement().tabs();
		}
	});

	// /EVENTS

	// ADAPTERS

	this.getBudgetHandler().getMonths().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "addall":
			if (context.isVisible() && context.monthId) {
				context.show(context.monthId);
			}
			break;
		}
	});

	// /ADAPTERS

	// ENTRIES

	this.getEntriesPresenter().setClickCallback("entry", function(entryId, entryElement) {
		context.getEntriesPresenter().doEntrySelect(entryId, entryElement);
	});

	// /ENTRIES
};

// ... /DO

// ... HANDLE

MonthPageMainView.prototype.handleMonthsRetrieved = function(months) {
	months = months || {};
	for (month in months) {
		this.getEntriesPresenter().addMonth(month, months[month]);
	}
};

MonthPageMainView.prototype.handleFilter = function(filter) {
	if (jQuery.isEmptyObject(filter)) {
		this.getActionbarPresenter().getButtonsElement().find("#filter_button").attr("data-disabled", "true");
	} else {
		this.getActionbarPresenter().getButtonsElement().find("#filter_button").removeAttr("data-disabled");
	}

	this.getEntriesPresenter().doFilter(filter);

	this.getEventHandler().handle(new ToastEvent("Filtered Entries"));
};

// ... /HANDLE

MonthPageMainView.prototype.show = function(monthId) {
	PageMainView.prototype.show.call(this);
	var context = this;

	this.monthId = monthId;
	this.month = this.getBudgetHandler().getMonths().getItem(this.monthId);

	if (!this.month)
		return console.error("Month page show month is empty", this.monthId);

	var date = new Date(this.month.date * 1000);

	// ACTIONBAR

	this.getActionbarPresenter().doSetReferral(function() {
		context.getView().getController().updateHash({
			page : "budget"
		});
	});
	this.getActionbarPresenter().doSetIcon($("<div />", {
		"data-icon" : "calendar"
	}));

	// View contorl
	this.getActionbarPresenter().doSetViewControl(date.format("mmmm"), date.format("yyyy"));

	// View control menu
	this.getActionbarPresenter().doEmptyViewControlMenu();
	var months = this.getBudgetHandler().getMonths().getArray();
	months.sort(function(left, right) {
		return right.date - left.date;
	});
	var month = null, monthDate = null;
	for ( var i in months) {
		month = months[i];
		monthDate = new Date(month.date * 1000);
		this.getActionbarPresenter().doAddViewControlMenu(monthDate.format("mmmm"), monthDate.format("yyyy"), month.id, function(id) {
			console.log("Month select", id);
			context.getController().updateHash({
				page : "month",
				month : id
			});
		});
	}

	// Buttons
	this.getActionbarPresenter().doEmptyButtons();
	this.getActionbarPresenter().doAddButton($("<div />", {
		"data-icon" : "filter",
		"data-disabled" : this.getEntriesPresenter().filter ? null : "true",
		"id" : "filter_button"
	}), function(button) {
		context.getView().getController().updateHash({
			filter : null
		});
	});

	this.getActionbarPresenter().doAddButton($("<div />", {
		"data-icon" : "edit",
		"data-disabled" : "true",
		"id" : "edit_button"
	}), function(button) {
		var entryId = button.attr("data-edit");
		if (entryId)
			context.getView().getController().updateHash({
				overlay : "entry",
				entry : entryId
			});
	});
	this.getActionbarPresenter().doAddButton($("<div />", {
		"data-icon" : "settings"
	}), function() {
		context.getView().getController().updateHash({
			overlay : "settings"
		});
	});
	this.getActionbarPresenter().doAddButton($("<div />", {
		"data-icon" : "plus"
	}), function() {
		context.getView().getController().updateHash({
			overlay : "entry",
			entry : null
		});
	});

	// /ACTIONBAR

	// TABS

	this.getTabsElement().tabs({
		selectCallback : function(tab) {
			context.getView().getController().setLocalStorageVariable("month_tab", tab);

			switch (tab) {
			case "chart_month":
				context.chartDraw = true;
				context.drawChart();
				break;
			}
		}
	});

	var monthTab = this.getView().getController().getLocalStorageVariable("month_tab");
	if (monthTab)
		this.getTabsElement().tabs("tab", monthTab);
	if (monthTab == "chart_month") {
		this.chartDraw = true;
		context.drawChart();
	}

	// /TABS

	// ENTRIES

	this.getEntriesPresenter().getMonthElements().addClass("hide").removeClass("selected");
	// this.getEntriesPresenter().getMonthsEntriesElements().empty();
	this.getEntriesPresenter().doMonthSelect(monthId);

	// /ENTRIES

	// OVERVIEW

	var cards = this.getBudgetHandler().getCards().getFilteredList(function(card) {
		return card.joint == 0;
	});
	this.getOverviewPresenter().setEntriesList(this.getBudgetHandler().getEntries());
	this.getOverviewPresenter().setCardsCount(Core.countObject(cards));
	this.getOverviewPresenter().doDrawMonth(this.month);
	this.getOverviewPresenter().isShown = true;

	// /OVERVIEW

	// CHART

	// /CHART

};

// ... DO

MonthPageMainView.prototype.doLoadChartApi = function() {
	if (this.chartApiLoad)
		return;
	$("body").append($("<script />", {
		src : "https://www.google.com/jsapi?callback=loadChartApi",
		type : "text/javascript"
	}));
	$("body")
			.append(
					$(
							"<script />",
							{
								type : "text/javascript",
								text : "function loadChartApi(){\ngoogle.load(\"visualization\", \"1\", {packages:[\"corechart\"], callback: function(){\neventHandler.handle(new ChartloadEvent());}});}\n"
							}));

	this.chartApiLoad = true;
};

// ... /DO

MonthPageMainView.prototype.drawChart = function() {
	this.doLoadChartApi();
	if (!this.chartDraw || !this.chartLoad || !this.chartApiLoad)
		return;

	this.getChartWrapperElement().empty();
	var width = this.getChartWrapperElement().innerWidth();
	var height = Math.round(width * 0.75);

	var options = {
		isStacked : true,
		axisTitlesPosition : "none",
		width : width,
		height : height,
		legend : {
			position : "none"
		},
		chartArea : {
			'width' : '100%',
			'height' : '100%'
		}
	};

	var dataArray = [];
	dataArray.push([ 'Day', (new Date(this.month.date)).format("mmmm") ]);

	for ( var day in this.month.total) {
		dataArray.push([ day, Core.roundNumber(parseFloat(this.month.total[day])) ]);
	}
	// var data = google.visualization.arrayToDataTable([ [ 'Day', 'January',
	// 'Februrary', 'March', 'April', 'May' ], [ '1', 165, 938, 522, 998, 450 ],
	// [ '5', 135, 1120, 599, 1268, 288 ], [ '10', 157, 1167, 587, 807, 397 ], [
	// '15', 139, 1110, 615, 968, 215 ], [ '30', 136, 691, 629, 1026, 366 ],
	// [ '20', 136, 691, 629, 1026, 366 ] ]);
	var data = google.visualization.arrayToDataTable(dataArray);

	var ac = new google.visualization.AreaChart(document.getElementById(this.getChartWrapperElement().attr("id")));
	ac.draw(data, options);
};

MonthPageMainView.prototype.doBefore = function() {
	PageMainView.prototype.doBefore.call(this);

	this.getEntriesPresenter().setMonthsList(this.getBudgetHandler().getMonths());
	this.getEntriesPresenter().setEntriesList(this.getBudgetHandler().getEntries());
	this.getEntriesPresenter().setCardsList(this.getBudgetHandler().getCards());
	this.getEntriesPresenter().setTypesList(this.getBudgetHandler().getTypes());
};

/**
 * @param {Object}
 *            root
 */
MonthPageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);

	this.getEntriesPresenter().draw(this.getEntriesWrapperElement());
	this.getOverviewPresenter().draw(this.getOverviewWrapperElement());
};

// ... /HANDLE

// /FUNCTIONS
