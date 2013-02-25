// CONSTRUCTOR
EntriesPresenterView.prototype = new AbstractPresenterView();

function EntriesPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);
	this.months = null;
	this.types = null;
	this.cards = null;
	this.monthTemplateElement = null;
	this.entryTemplateElement = null;
	this.clickCallbacks = {
		"month" : null,
		"monthLong" : null,
		"entry" : null,
		"entryLong" : null
	};
	this.filter = null;
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

// ... ... GETTERS/SETTERS

/**
 * @param {ListAdapter}
 *            months
 */
EntriesPresenterView.prototype.setMonthsList = function(months) {
	this.months = months;
};

/**
 * @returns {ListAdapter}
 */
EntriesPresenterView.prototype.getMonthsList = function() {
	return this.months;
};

/**
 * @param {ListAdapter}
 *            entries
 */
EntriesPresenterView.prototype.setEntriesList = function(entries) {
	this.entries = entries;
};

/**
 * @returns {ListAdapter}
 */
EntriesPresenterView.prototype.getEntriesList = function() {
	return this.entries;
};

/**
 * @param {ListAdapter}
 *            cards
 */
EntriesPresenterView.prototype.setCardsList = function(cards) {
	this.cards = cards;
};

/**
 * @returns {ListAdapter}
 */
EntriesPresenterView.prototype.getCardsList = function() {
	return this.cards;
};

/**
 * @param {ListAdapter}
 *            types
 */
EntriesPresenterView.prototype.setTypesList = function(types) {
	this.types = types;
};

/**
 * @returns {ListAdapter}
 */
EntriesPresenterView.prototype.getTypesList = function() {
	return this.types;
};

// ... ... /GETTERS/SETTERS

// ... ... ELEMENT

EntriesPresenterView.prototype.getEntriesElement = function() {
	return this.getRoot().find("table.entries");
};

EntriesPresenterView.prototype.getMonthElement = function(monthId) {
	return this.getEntriesElement().find("tbody.month[data-month=" + monthId + "]");
};

EntriesPresenterView.prototype.getMonthElements = function() {
	return this.getEntriesElement().find("tbody.month:NOT(.template)");
};

EntriesPresenterView.prototype.getMonthBetweenElement = function(monthId) {
	var element = null, elementMonthId = 0, monthIdTemp = null;
	this.getMonthElements().each(function() {
		monthIdTemp = parseInt($(this).attr("data-month"));
		if (((elementMonthId && monthIdTemp < elementMonthId) || !elementMonthId) && monthId > elementMonthId) {
			element = $(this);
			elementMonthId = monthIdTemp;
		}
	});
	console.log("Month between element", monthId, element);
	return element;
};

EntriesPresenterView.prototype.getMonthsEntriesElements = function() {
	return this.getEntriesElement().find("tbody.month_entries:NOT(.template)");
};

EntriesPresenterView.prototype.getMonthEntriesElements = function(monthId) {
	return this.getEntriesElement().find("tbody.month_entries[data-month=\"" + monthId + "\"]");
};

EntriesPresenterView.prototype.getEntryElements = function() {
	return this.getEntriesElement().find("tbody.month_entries:NOT(.template) tr.entry");
};

EntriesPresenterView.prototype.getEntryElement = function(entryId) {
	return this.getEntryElements().filter("[data-entry=" + entryId + "]");
};

// ... ... /ELEMENT

/**
 * @returns {EventHandler}
 */
EntriesPresenterView.prototype.getEventHandler = function() {
	return this.getView().getEventHandler();
};

/**
 * @returns {BudgetHandler}
 */
EntriesPresenterView.prototype.getBudgetHandler = function() {
	return this.getView().getBudgetHandler();
};

// ... /GET

// ... SET

EntriesPresenterView.prototype.setClickCallback = function(type, callback) {
	this.clickCallbacks[type] = callback;
};

// ... /SET

// ... IS

EntriesPresenterView.prototype.isMonthSelected = function(monthId) {
	var monthElement = this.getMonthElement(monthId);
	return monthElement.hasClass("selected");
};

// ... /IS

// ... DO

EntriesPresenterView.prototype.doBindEventHandler = function() {
	AbstractPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// /EVENTS

	// LIST ADAPTERS

	this.getMonthsList().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "addall":
			for ( var monthId in object)
				context.addMonth(monthId, object[monthId]);
			context.doMonthSort();
			break;

		case "clear":
			context.clearMonths();
			break;
		}
	});

	this.getCardsList().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "addall":
			context.doUpdateCards(object);
			break;

		case "add":
			var cards = {};
			cards[object.id] = object;
			context.doUpdateCards(cards);
			break;
		}
	});

	this.getTypesList().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "addall":
			context.doUpdateTypes(object);
			break;

		case "add":
			var types = {};
			types[object.id] = object;
			context.doUpdateTypes(types);
			break;
		}
	});

	this.getEntriesList().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "add":
			var entries = {};
			entries[object.id] = object;
			context.addEntries(entries);
			break;

		case "addall":
			context.addEntries(object);
			break;

		case "remove":
			context.removeEntry(object.id);
			break;

		case "clear":
			context.clearEntries();
			break;
		}
	});

	// /LIST ADAPTERS

	// BINDS

	this.getEntriesElement().unbind(".entries").on("taphold.entries", {
		clickHandler : function(event) {
			var target = $(event.target);
			var month = target.closest("tbody.month");
			var entry = target.closest("tr.entry");

			// Month
			if (month.length > 0) {
				var monthId = month.attr("data-month");
				context.doMonthClick(monthId, month);
			}
			// Entry
			else if (entry.length > 0) {
				var entryId = entry.attr("data-entry");
				context.doEntryClick(entryId, entry);
			}
		}
	}, function(event) {
		event.stopPropagation();
		event.preventDefault();
		var target = $(event.target);
		var month = target.closest("tbody.month");
		var entry = target.closest("tr.entry");

		// Month
		if (month.length > 0) {
			var monthId = month.attr("data-month");
			context.doMonthClickLong(monthId, month);
		}
		// Entry
		else if (entry.length > 0) {
			var entryId = entry.attr("data-entry");
			context.doEntryClickLong(entryId, entry);
		}
	});

	// this.getEntriesElement().unbind(".entries").bind("touchclick.entries",
	// function(event) {
	// var target = $(event.target);
	// var month = target.closest("tbody.month");
	// var entry = target.closest("tr.entry");
	// console.log("touchclick: " + event.originalEvent.type);
	// // Month
	// if (month.length > 0) {
	// var monthId = month.attr("data-month");
	// context.doMonthClick(monthId, month);
	// }
	// // Entry
	// else if (entry.length > 0) {
	// var entryId = entry.attr("data-entry");
	// context.doEntryClick(entryId, entry);
	// }
	// }).bind("taphold.entries", function(event) {
	// event.stopPropagation();
	// event.preventDefault();
	// var target = $(event.target);
	// var month = target.closest("tbody.month");
	// var entry = target.closest("tr.entry");
	// console.log("taphold: " + event.originalEvent.type);
	// // Month
	// if (month.length > 0) {
	// var monthId = month.attr("data-month");
	// context.doMonthClickLong(monthId, month);
	// }
	// // Entry
	// else if (entry.length > 0) {
	// var entryId = entry.attr("data-entry");
	// context.doEntryClickLong(entryId, entry);
	// }
	//
	// });

	// /BINDS
};

EntriesPresenterView.prototype.doBefore = function() {
	AbstractPresenterView.prototype.doBefore.call();

	this.monthTemplateElement = this.getEntriesElement().find("tbody.month.template");
	this.entryTemplateElement = this.getEntriesElement().find("tbody.month_entries.template");
};

// ... ... CLICK

EntriesPresenterView.prototype.doMonthClick = function(monthId, monthElement) {
	if (this.clickCallbacks["month"])
		this.clickCallbacks["month"](monthId, monthElement);
};

EntriesPresenterView.prototype.doMonthClickLong = function(monthId, monthElement) {
	if (this.clickCallbacks["monthLong"])
		this.clickCallbacks["monthLong"](monthId, monthElement);
};

EntriesPresenterView.prototype.doEntryClick = function(entry, entryElement) {
	if (this.clickCallbacks["entry"])
		this.clickCallbacks["entry"](entry, entryElement);
};

EntriesPresenterView.prototype.doEntryClickLong = function(entry, entryElement) {
	if (this.clickCallbacks["entryLong"])
		this.clickCallbacks["entryLong"](entry, entryElement);
};

// ... ... /CLICK

// ... ... SELECT

EntriesPresenterView.prototype.doMonthSelect = function(monthId, monthElement) {
	monthElement = monthElement || this.getMonthElement(monthId);
	var selected = monthElement.hasClass("selected");
	this.getMonthElements().removeClass("selected");

	if (!selected && monthId && monthElement.length > 0) {
		monthElement.addClass("selected").removeClass("hide");
	}
};

EntriesPresenterView.prototype.doEntrySelect = function(entryId, entry) {
	entry = entry || this.getEntryElement(entryId);

	this.getEntryElements().removeClass("selected");
	entry.addClass("selected");

	// Send Select event
	this.getEventHandler().handle(new SelectEvent("entry", entryId));
};

// ... ... /SELECT

EntriesPresenterView.prototype.doFilter = function(filter) {
	this.filter = filter;
	var filterSelector = "";
	for ( var type in filter) {
		filterSelector += "[data-" + type + "=" + filter[type] + "]";
	}

	if (filterSelector == "") {
		this.getEntryElements().removeClass("hide");
		this.filter = null;
	} else
		this.getEntryElements().addClass("hide").filter(filterSelector).removeClass("hide");
};

EntriesPresenterView.prototype.doUpdateCards = function(cards) {
	var entriesElement = null;
	for ( var cardId in cards) {
		entriesElement = this.getEntryElements().filter("[data-card=" + cardId + "]");
		entriesElement.find(".type_card_comment .card").text(cards[cardId].title);
	}
};

EntriesPresenterView.prototype.doUpdateTypes = function(types) {
	var entriesElement = null;
	for ( var typeId in types) {
		entriesElement = this.getEntryElements().filter("[data-type=" + typeId + "]");
		entriesElement.find(".type_card_comment .type").text(types[typeId].title);
	}
};

EntriesPresenterView.prototype.doMonthSort = function() {
	var entriesElement = this.getEntriesElement().children().filter("[data-month]");
	entriesElement.sortElements(function(left, right) {
		return $(left).attr("data-month") == $(right).attr("data-month") ? ($(left).is(".month") ? -1 : 1) : ($(left).attr("data-month") > $(right).attr("data-month") ? -1 : 1);
	});
};

// ... /DO

EntriesPresenterView.prototype.addMonth = function(monthId, month) {
	var monthDate = new Date(month.date * 1000);

	// Month
	var monthElement = this.getMonthElement(monthId);
	if (monthElement.length == 0) {
		monthElement = this.monthTemplateElement.clone();

		// Month entries
		var monthEntriesElement = this.entryTemplateElement.clone();
		monthEntriesElement.removeClass("template");
		monthEntriesElement.attr("data-month", monthId);
		monthEntriesElement.find("tr.entry").remove();
		this.getEntriesElement().append(monthElement);
		monthElement.after(monthEntriesElement);
	}

	monthElement.removeClass("template");
	monthElement.attr("data-month", monthId);
	monthElement.attr("data-entries", month.entries);

	monthElement.find("td.monthyear .month").text(monthDate.format("mm"));
	monthElement.find("td.monthyear .year").text(monthDate.format("yy"));
	monthElement.find("td.month .month").text(monthDate.format("mmmm"));
	monthElement.find("td.month .entries").text(month.entries);
	monthElement.find("td.cost_sum").text(month.costSum.toFixed(2));
};

EntriesPresenterView.prototype.addEntries = function(entries) {
	var monthEntriesElements = {};

	for ( var entryId in entries) {
		var entryDate = new Date(entries[entryId].date * 1000);
		var monthId = entryDate.format("yymm");

		if (!monthEntriesElements[monthId]) {
			monthEntriesElements[monthId] = this.getMonthEntriesElements(monthId);
			if (monthEntriesElements[monthId].length == 0) {
				console.error("Entry \"" + entryId + "\ does not have parent month \"" + monthId + "\"");
				break;
			}
		}

		var entryElement = this.getEntryElement(entryId);
		if (entryElement.length == 0) {
			entryElement = this.entryTemplateElement.find("tr.entry").clone();
			monthEntriesElements[monthId].append(entryElement);
		}
		this.addEntry(entryElement, entryId, entries[entryId]);
	}

	for ( var monthId in monthEntriesElements) {
		// Sort
		monthEntriesElements[monthId].find("tr.entry").sortElements(function(a, b) {
			return $(a).attr("data-date") > $(b).attr("data-date") ? -1 : 1;
		});
		// Hide loading
		monthEntriesElements[monthId].find("tr.entry_loading").addClass("hide");
	}

	// Filter
	if (this.filter)
		this.doFilter(this.filter);
};

EntriesPresenterView.prototype.addEntry = function(entryElement, entryId, entry) {
	var entryDate = new Date(entry.date * 1000);
	var entryLastModified = new Date((Math.max(entry.registered, entry.updated)) * 1000);

	var card = $.extend({
		title : null,
		number : null
	}, this.getBudgetHandler().getCards().getItem(entry.card));
	var type = $.extend({
		title : null
	}, this.getBudgetHandler().getTypes().getItem(entry.type));

	// Entry
	entryElement.attr("data-entry", entryId);
	entryElement.attr("data-month", entry.monthId);
	entryElement.attr("data-card", entry.card);
	entryElement.attr("data-type", entry.type);
	entryElement.attr("data-date", entry.date);
	entryElement.attr("data-positive", entry.credit == 1 ? "true" : null);
	entryElement.attr("data-single", entry.single == 1 ? "true" : null);

	entryElement.find("td.date").text(entryDate.format("dd"));
	entryElement.find("td.type").text(type.title);
	entryElement.find("td.card").html($("<span />", {
		text : entryLastModified.format("HH:MM dd. mmm yy")
	}).after(card.title)).attr("title", card.number);
	entryElement.find("td.cost").text(entry.cost.toFixed(2));
	entryElement.find("td.comment").text(entry.comment).removeClass("hide");
	if (!entry.comment)
		entryElement.find("td.comment").parent().addClass("hide");
};

EntriesPresenterView.prototype.removeEntry = function(entryId) {
	var entryElement = this.getEntryElement(entryId);

	if (entryElement.length > 0) {
		entryElement.remove();
	}
};

EntriesPresenterView.prototype.clearMonths = function() {
	this.getMonthElements().removeClass("selected");
	this.getMonthElements().remove();
	this.clearEntries();
};

EntriesPresenterView.prototype.clearEntries = function() {
	this.getMonthElements().removeClass("selected");
	this.getMonthsEntriesElements().empty();
};

// /FUNCTIONS
