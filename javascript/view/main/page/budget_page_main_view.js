// CONSTRUCTOR
BudgetPageMainView.prototype = new PageMainView();

function BudgetPageMainView(view) {
	PageMainView.apply(this, arguments);
	this.entriesPresenter = new EntriesPresenterView(view);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BudgetMainView}
 */
BudgetPageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

/**
 * @return {EntriesPresenterView}
 */
BudgetPageMainView.prototype.getEntriesPresenter = function() {
	return this.entriesPresenter;
};

// ... ... ELEMENT

BudgetPageMainView.prototype.getEntriesWrapperElement = function() {
	return this.getRoot().find(".entries_wrapper");
};

// ... ... /ELEMENT

// ... /GET

// ... DO

BudgetPageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// EVENTS

	// Handle "Select" event
	this.getController().getEventHandler().registerListener(SelectEvent.TYPE,
	/**
	 * @param {SelectEvent}
	 *            event
	 */
	function(event) {
		switch (event.getSelectType()) {

		case "month":
			context.getEntriesPresenter().doMonthSelect(event.getId());
			break;

		case "entry":
			context.handleEntrySelect(event.getId());
			break;

		}
	});

	// /EVENTS

	// Entries click
	this.getEntriesPresenter().setClickCallback("month", function(monthId, monthElement) {
		if (!context.getEntriesPresenter().isMonthSelected(monthId))
			context.getController().updateHash({
				month : monthId
			});
		else
			context.getController().updateHash({
				month : null
			});
	});
	this.getEntriesPresenter().setClickCallback("monthLong", function(monthId, monthElement) {
		context.getController().updateHash({
			page : "month",
			month : monthId
		});
	});
	this.getEntriesPresenter().setClickCallback("entry", function(entryId, entryElement) {
		context.getEntriesPresenter().doEntrySelect(entryId, entryElement);
	});
};

// ... /DO

// ... HANDLE

// BudgetPageMainView.prototype.handleMonthsRetrieved = function(months) {
// months = months || {};
// for (month in months) {
// this.getEntriesPresenter().addMonth(month, months[month]);
// }
// };
//
// BudgetPageMainView.prototype.handleMonthRetrieved = function(entries) {
// this.getEntriesPresenter().addEntries(entries);
// };

BudgetPageMainView.prototype.handleEntrySelect = function(entryId) {
	var editButton = this.getActionbarPresenter().getButtonElement("edit_button");
	editButton.removeAttr("data-disabled").attr("data-edit", entryId);
};

// ... /HANDLE

BudgetPageMainView.prototype.show = function() {
	var context = this;
	var budget = this.getBudgetHandler().getBudget();

	// ACTIONBAR

	// this.getActionbarPresenter().setReferral("#test");
	this.getActionbarPresenter().doSetReferral(null);
	this.getActionbarPresenter().doEmptyButtons();
	this.getActionbarPresenter().doSetIcon($("<div />", {
		"data-icon" : "pie"
	}));
	this.getActionbarPresenter().doSetViewControl("Budget", budget.title);

	// View control menu
	this.getActionbarPresenter().doEmptyViewControlMenu();
	var budgets = this.getBudgetHandler().getBudgets().getAll(), budget = null, users = "";
	for ( var i in budgets) {
		budget = budgets[i];
		users = Core.sprintf("(%d)", budget.users.length);
		this.getActionbarPresenter().doAddViewControlMenu(budget.title, users, budget.id, function(id) {
			context.getEventHandler().handle(new BudgetEvent(id));
		});
	}

	// Buttons
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

	PageMainView.prototype.show.call(this);
};

BudgetPageMainView.prototype.doBefore = function() {
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
BudgetPageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);

	this.getRoot().find(".tabs_wrapper").tabs();
	this.getEntriesPresenter().draw(this.getEntriesWrapperElement());
};

// /FUNCTIONS
