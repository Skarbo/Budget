// CONSTRUCTOR
OverviewMonthPresenterView.prototype = new AbstractPresenterView();

function OverviewMonthPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);
	this.cardWrapperTemplateElement = null;
	this.cardRowTemplateElement = null;
	this.typeRowTemplateElement = null;
	this.entryRowTemplateElement = null;
	this.entries = null;
	this.month = null;
	this.cardsCount = 0;
	// this.cardSumRowTemplateElement = null;
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {BudgetHandler}
 */
OverviewMonthPresenterView.prototype.getBudgetHandler = function() {
	return this.getView().getBudgetHandler();
};

/**
 * @param {ListAdapter}
 *            entries
 */
OverviewMonthPresenterView.prototype.setEntriesList = function(entries) {
	this.entries = entries;
};

/**
 * @returns {ListAdapter}
 */
OverviewMonthPresenterView.prototype.getEntriesList = function() {
	return this.entries;
};

/**
 * @param {Number}
 *            cardsCount
 */
OverviewMonthPresenterView.prototype.setCardsCount = function(cardsCount) {
	this.cardsCount = cardsCount;
};

/**
 * @returns {Number}
 */
OverviewMonthPresenterView.prototype.getCardsCount = function() {
	return this.cardsCount;
};

// ... ... ELEMENT

OverviewMonthPresenterView.prototype.getOverviewElement = function() {
	return this.getRoot().find("table.overview_table");
};

OverviewMonthPresenterView.prototype.getCardWrapperElement = function() {
	return this.getOverviewElement().find(".card_wrapper:NOT(.template)");
};

OverviewMonthPresenterView.prototype.getTypeRowElement = function() {
	return this.getCardWrapperElement().find(".type_row");
};

OverviewMonthPresenterView.prototype.getCardWrapperTemplateElement = function() {
	return this.getOverviewElement().find("tbody.card_wrapper.template");
};

OverviewMonthPresenterView.prototype.getEntriesRowsElement = function() {
	return this.getCardWrapperElement().find(".entry_row");
};

// ... ... /ELEMENT

// ... /GET

// ... CREATE

OverviewMonthPresenterView.prototype.createMonthCardType = function(typeId, budgetCardType) {
	var isSum = typeId == 0;
	var typeRowElement = this.typeRowTemplateElement.clone();
	var type = {
		title : ""
	};
	if (!isSum)
		type = $.extend(type, this.getBudgetHandler().getTypes().getItem(typeId));

	typeRowElement.attr("data-sum", isSum ? "true" : null);
	typeRowElement.attr("data-type", !isSum ? typeId : null);
	typeRowElement.attr("data-card", budgetCardType.card ? budgetCardType.card : null);
	typeRowElement.find(".type").text(type.title);
	typeRowElement.find(".prday").text(Math.abs(budgetCardType.prday).toFixed(2)).attr("data-positive", budgetCardType.prday < 0 ? "true" : null);
	typeRowElement.find(".entries").text(budgetCardType.entries);
	typeRowElement.find(".sum").text(Math.abs(budgetCardType.costSum).toFixed(2)).attr("data-positive", budgetCardType.costSum < 0 ? "true" : null);

	return typeRowElement;
};

OverviewMonthPresenterView.prototype.createMonthCard = function(cardId, budgetCards) {
	var isSum = cardId == 0;
	var card = {};
	if (isSum)
		card = {
			title : "Sum",
			number : ""
		};
	else
		card = $.extend(card, this.getBudgetHandler().getCards().getItem(cardId));

	var cardWrapperElement = this.cardWrapperTemplateElement.clone();
	var cardRowElement = this.cardRowTemplateElement.clone();
	// var cardSumRowElement = this.cardSumRowTemplateElement.clone();

	// Card
	cardRowElement.find(".card").text(card.title).attr("title", card.number);
	cardWrapperElement.append(cardRowElement);

	// Types
	var cardSum = {
		entries : 0,
		costSum : 0,
		prday : 0
	};
	for ( var typeId in budgetCards) {
		cardWrapperElement.append(this.createMonthCardType(typeId, budgetCards[typeId]));

		cardSum.entries += budgetCards[typeId].entries;
		cardSum.costSum += budgetCards[typeId].costSum;
		cardSum.prday += budgetCards[typeId].prday;
	}

	// Card sum
	cardWrapperElement.append(this.createMonthCardType(0, cardSum));

	// cardSumRowElement.find(".prday").text(Math.abs(cardPrDay).toFixed(2)).attr("data-negative",
	// cardPrDay < 0 ? "true" : null);
	// cardSumRowElement.find(".sum").text(Math.abs(cardSum).toFixed(2)).attr("data-negative",
	// cardSum < 0 ? "true" : null);
	// cardWrapperElement.append(cardSumRowElement);

	return cardWrapperElement;
};

// ... /CREATE

// ... DO

OverviewMonthPresenterView.prototype.doBindEventHandler = function() {
	var context = this;

	// BINDS

	this.getOverviewElement().unbind(".overview").bind("touchclick.overview", function(event) {
		event.preventDefault();
		var typeRow = $(event.target).closest("tr.type_row:NOT([data-sum])");

		if (typeRow.length > 0) {
//			var filter = {
//				type : typeRow.attr("data-type") || null,
//				card : typeRow.attr("data-card") || null
//			};
//			context.getView().getController().updateHash({
//				filter : filter
//			});
			context.doShowEntries(typeRow);
		}
	}).bind("longclick.overview", 500, function(event) {

	});

	// /BINDS
};

OverviewMonthPresenterView.prototype.doBefore = function() {
	AbstractPresenterView.prototype.doBefore.call();

	var templateElement = this.getCardWrapperTemplateElement();
	this.cardWrapperTemplateElement = templateElement.clone().removeClass("template").empty();
	this.cardRowTemplateElement = templateElement.find("tr.card_row").clone();
	this.typeRowTemplateElement = templateElement.find("tr.type_row").clone();
	this.entryRowTemplateElement = templateElement.find("tr.entry_row").clone();
};

OverviewMonthPresenterView.prototype.doEmptyMonth = function() {
	this.getCardWrapperElement().empty();
};

OverviewMonthPresenterView.prototype.doDrawMonth = function(month) {
	this.month = month;
	var budget = month.budgets;

	this.doEmptyMonth();

	var cardSumWrapperElement = null;
	for ( var cardId in budget) {
		if (cardId == 0)
			cardSumWrapperElement = this.createMonthCard(cardId, budget[cardId]);
		else
			this.getOverviewElement().append(this.createMonthCard(cardId, budget[cardId]));
	}
	cardSumWrapperElement.addClass("sum");
	this.getOverviewElement().append(cardSumWrapperElement);

	this.getTypeRowElement().touchActive();
};

OverviewMonthPresenterView.prototype.doShowEntries = function(typeRow) {
	var context = this;
	var cardId = typeRow.attr("data-card") || null;
	var typeId = typeRow.attr("data-type") || null;
	var isSelected = typeRow.is(".selected");
	this.getTypeRowElement().removeClass("selected");
	this.getEntriesRowsElement().remove();

	if (this.month && !isSelected && typeId) {
		typeRow.addClass("selected");
		
		var entries = this.getEntriesList().getFilteredList(function(entry) {
			return entry.monthId == context.month.id && entry.type == typeId && ((cardId && entry.card == cardId) || !cardId);
		});
		
		var entry = null, entryRow = null, entryDate = null, divide = 0, costSum = 0;
		for ( var entryId in entries) {
			entry = entries[entryId];
			entryRow = this.entryRowTemplateElement.clone();
			entryDate = new Date(entry.date * 1000);
			divide = entry.single == 1 ? 1 : context.getCardsCount() || 1;
			costSum = entry.cost / divide;

			entryRow.attr("data-date", entry.date);
			entryRow.attr("data-positive", entry.credit == 1 ? "true" : null);
			entryRow.find(".date").text(entryDate.format("dd"));
			entryRow.find(".comment_cost .comment").text(entry.comment || "");
			entryRow.find(".comment_cost .cost").text(entry.cost.toFixed(2));
			entryRow.find(".single").text(divide);
			entryRow.find(".cost_sum").text(costSum.toFixed(2));

			typeRow.after(entryRow);
		}
		
		this.getEntriesRowsElement().sortElements(function(a, b) {
			return $(a).attr("data-date") < $(b).attr("data-date") ? -1 : 1;
		});
	}
};

// ... /DO

// /FUNCTIONS
