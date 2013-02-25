/**
 * Budget handler
 */
function BudgetHandler(controller) {
	this.controller = controller;
	this.user = null;
	this.budetId = null;
	this.months = new ListAdapter();
	this.budgetDao = new BudgetStandardDao(controller.getMode());
	this.entryDao = new EntryStandardDao(controller.getMode());
	this.typeDao = new TypeStandardDao(controller.getMode());
	this.cardDao = new CardStandardDao(controller.getMode());
};

// CONSTANTS

BudgetHandler.URI_BUDGET = "api_rest.php?/budgets/%s&mode=%s";

// /CONSTANTS

// FUNCTIONS

// ... GET

/**
 * @returns {BudgetMainController}
 */
BudgetHandler.prototype.getController = function() {
	return this.controller;
};

/**
 * @returns {Object}
 */
BudgetHandler.prototype.getUser = function() {
	return this.user;
};

/**
 * @returns {Number}
 */
BudgetHandler.prototype.getBudgetId = function() {
	return this.budetId;
};

/**
 * @returns {Object}
 */
BudgetHandler.prototype.getBudget = function() {
	return this.getBudgets().getItem(this.getBudgetId());
};

/**
 * @returns {ListAdapter}
 */
BudgetHandler.prototype.getBudgets = function() {
	return this.getBudgetDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
BudgetHandler.prototype.getMonths = function() {
	return this.months;
};

/**
 * @returns {ListAdapter}
 */
BudgetHandler.prototype.getEntries = function() {
	return this.getEntryDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
BudgetHandler.prototype.getTypes = function() {
	return this.getTypeDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
BudgetHandler.prototype.getCards = function() {
	return this.getCardDao().getListAdapter();
};

// ... ... DAO

/**
 * @returns {BudgetStandardDao}
 */
BudgetHandler.prototype.getBudgetDao = function() {
	return this.budgetDao;
};

/**
 * @returns {EntryStandardDao}
 */
BudgetHandler.prototype.getEntryDao = function() {
	return this.entryDao;
};

/**
 * @returns {CardStandardDao}
 */
BudgetHandler.prototype.getCardDao = function() {
	return this.cardDao;
};

/**
 * @returns {TypeStandardDao}
 */
BudgetHandler.prototype.getTypeDao = function() {
	return this.typeDao;
};

// ... ... /DAO

// ... /GET

// ... HANDLE

/**
 * @param {object}
 *            Sessiosn
 */
BudgetHandler.prototype.handleRetrievedBudget = function(data) {
	var isChangeBudget = this.budetId != data.budget;

	if (isChangeBudget) {
		// Clear lists
		this.getBudgets().clear();
		this.getTypes().clear();
		this.getCards().clear();
		this.getMonths().clear();
		this.getEntries().clear();
	}

	// Set User
	this.user = data.user;

	// Set Budget
	this.budetId = data.budget;
	this.getBudgets().setList(data.budgets);

	// Set Types
	this.getTypes().setList(data.types);

	// Set Cards
	this.getCards().setList(data.cards);

	// Set Months
	this.getMonths().setList(data.months);

	// Sort Months
	// this.doSortMonths();

	// Send Event
	this.getController().getEventHandler().handle(new RetrievedEvent("budget", this.getMonths()));

};

// ... /HANDLE

// ... DO

BudgetHandler.prototype.doRetrieveBudget = function(budgetId, callback) {
	budgetId = budgetId || "";

	// Generate url
	var url = Core.sprintf(BudgetHandler.URI_BUDGET, budgetId, this.getController().getMode());

	// Send Event
	this.getController().getEventHandler().handle(new RetrieveEvent("budget"));

	// Do ajax
	$.ajax({
		type : "GET",
		url : url,
		dataType : "json",
		context : this,
		success : function(data) {
			this.handleRetrievedBudget(data);
			if (callback)
				callback();
		},
		error : function(jqXHR, textStatus, errorThrown) {
			this.getController().getEventHandler().handle(new ErrorEvent("BudgetMainController Retrieve Budget Error: " + textStatus));
		}
	});
};

BudgetHandler.prototype.doRetrieveEntries = function(monthId) {
	var context = this;
	this.getController().getEventHandler().handle(new RetrieveEvent("month"));
	this.getEntryDao().getMonth(this.budetId, monthId, function(list) {
		context.getController().getEventHandler().handle(new RetrievedEvent("month", list));
	});
};

// ... /DO
