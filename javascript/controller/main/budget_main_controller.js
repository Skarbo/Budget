// CONSTRUCTOR
BudgetMainController.prototype = new AbstractMainController();

/**
 * Budget Controller
 * 
 * @param {EventHandler}
 *            eventHandler
 */
function BudgetMainController(eventHandler, mode, query) {
	AbstractMainController.apply(this, arguments);
	this.handler = new BudgetHandler(this);
	this.query = {};
	this.queryLast = {};
}

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {BudgetHandler}
 */
BudgetMainController.prototype.getBudgetHandler = function() {
	return this.handler;
};

// ... /GET

// ... IS

/**
 * @returns {boolean}
 */
BudgetMainController.prototype.isPageChange = function() {
	return this.query.page != this.queryLast.page;
};

/**
 * @returns {boolean}
 */
BudgetMainController.prototype.isBudget = function() {
	return this.query.budget != this.queryLast.budget;
};

/**
 * @returns {boolean}
 */
BudgetMainController.prototype.isMonth = function() {
	return this.query.month != this.queryLast.month;
};

/**
 * @returns {boolean}
 */
BudgetMainController.prototype.isFilter = function() {
	return JSON.stringify(this.query.filter) != JSON.stringify(this.queryLast.filter);
};

/**
 * @returns {boolean}
 */
BudgetMainController.prototype.isOverlay = function() {
	return this.query.overlay != this.queryLast.overlay && !(!this.query.overlay);
};

/**
 * @returns {boolean}
 */
BudgetMainController.prototype.isOverlayClose = function() {
	return !this.query.overlay && !(!this.queryLast.overlay);
};

// ... /IS

// ... DO

BudgetMainController.prototype.doBindEventHandler = function() {
	AbstractMainController.prototype.doBindEventHandler.call(this);

	var context = this;

	// EVENTS

	// Handle "Budget" event
	this.getEventHandler().registerListener(BudgetEvent.TYPE,
	/**
	 * @param {BudgetEvent}
	 *            event
	 */
	function(event) {
		context.updateHash({
			budget : event.getId(),
			month : null,
			page : null
		});
	});

	// Handle "Save Entry" event
	this.getEventHandler().registerListener(SaveEntryBudgetEvent.TYPE,
	/**
	 * @param {SaveEntryBudgetEvent}
	 *            event
	 */
	function(event) {
		context.handleEntrySave(event.getEntry(), event.getEntryId());
	});
	this.getEventHandler().registerListener(SaveEvent.TYPE,
	/**
	 * @param {SaveEvent}
	 *            event
	 */
	function(event) {
		switch (event.getSaveType()) {
		case "card":
			context.handleCardSave(event.getObject(), event.getObjectId(), event.getCallback());
			break;

		case "type":
			context.handleTypeSave(event.getObject(), event.getObjectId(), event.getCallback());
			break;
			
		case "budget":
			context.handleBudgetSave(event.getObject(), event.getObjectId(), event.getCallback());
			break;
			
		case "budget_user":
			context.handleBudgetUserSave(event.getObject(), event.getObjectId(), event.getCallback());
			break;
		}
	});

	// Handle "Page" event
	this.getEventHandler().registerListener(PageEvent.TYPE,
	/**
	 * @param {PageEvent}
	 *            event
	 */
	function(event) {

	});

	// Handle "Select" event
	this.getEventHandler().registerListener(SelectEvent.TYPE,
	/**
	 * @param {SelectEvent}
	 *            event
	 */
	function(event) {
		switch (event.getSelectType()) {

		case "month":
			context.doRetrieveEntries(event.getId());
			break;

		}
	});

	// /EVENTS

	// HISTORY

	// Handle history
	$(window).hashchange(function() {
		context.handleRequest();
	});

	// History has change
	// $(window).hashchange();

	// /HISTORY

};

BudgetMainController.prototype.doRetrieveEntries = function(monthId) {
	if (monthId)
		this.getBudgetHandler().doRetrieveEntries(monthId);
};

// ... /DO

// ... HANDLE

BudgetMainController.prototype.handleRequest = function(isInit) {
	var context = this;
	this.query = this.getHash();

	// Budget
	if (!isInit && this.isBudget()) {
		this.getBudgetHandler().doRetrieveBudget(this.query.budget, function(){
			context.getEventHandler().handle(new ToastEvent("Changed Budget"));
		});
	}

	// Month
	if (this.isMonth()) {
		this.getEventHandler().handle(new SelectEvent("month", this.query.month));
	}

	// Page
	if (this.isPageChange()) {
		this.getEventHandler().handle(new PageEvent(this.query.page));
	} else if (isInit) {
		this.getEventHandler().handle(new PageEvent(null));
	}

	// Overlay
	if (this.isOverlay()) {
		this.handleOverlay(this.query.overlay, this.query);
	} else if (this.isOverlayClose()) {
		this.getEventHandler().handle(new CloseOverlayEvent(this.queryLast.overlay));
	}

	// Filter
	if (this.isFilter()) {
		this.getEventHandler().handle(new FilterEvent(this.query.filter));
	}

	this.queryLast = this.query;
};

BudgetMainController.prototype.handleOverlay = function(overlay, query) {
	switch (overlay) {

	// Entry
	case "entry":
		var entry = query.entry;
		if (!entry) {
			this.getEventHandler().handle(new NewEntryBudgetEvent());
		} else {
			this.getEventHandler().handle(new EditEntryBudgetEvent(entry));
		}
		break;

	default:
		this.getEventHandler().handle(new OverlayEvent(overlay));
		break;
	}
};

BudgetMainController.prototype.handleEntrySave = function(entry, entryId) {
	var context = this;
	var budgetId = this.getBudgetHandler().getBudgetId();
	
	// Retrieve months
	var retrieveMonths = function(entry) {
		// Retrieve months
		context.getBudgetHandler().doRetrieveBudget(budgetId, function() {
			// Entry retrieved
			context.getEventHandler().handle(new RetrievedEvent("entry", entry));
		});
	};

	// Edit
	if (entryId) {
		this.getEventHandler().handle(new ToastEvent("Editing Entry"));
		this.getBudgetHandler().getEntryDao().edit(entryId, entry, function(single, list) {
			context.getEventHandler().handle(new ToastEvent("Entry edited"));
			retrieveMonths();
		});
	}
	// New
	else {
		this.getEventHandler().handle(new ToastEvent("Adding Entry"));
		this.getBudgetHandler().getEntryDao().add(entry, budgetId, function(single, list) {
			context.getEventHandler().handle(new ToastEvent("Entry added"));
			retrieveMonths();
		});
	}
};

BudgetMainController.prototype.handleCardSave = function(card, cardId, callback) {
	var context = this;
	var budgetId = this.getBudgetHandler().getBudgetId();

	// New
	if (card && !cardId) {
		this.getBudgetHandler().getCardDao().add(card, budgetId, function(cardAdded) {
			context.getEventHandler().handle(new ToastEvent("Card added"));
			if (callback)
				callback(cardAdded);
		});
	}
	// Edit
	else if (card && cardId) {
		this.getBudgetHandler().getCardDao().edit(cardId, card, function(cardEdited) {
			context.getEventHandler().handle(new ToastEvent("Card edited"));
			if (callback)
				callback(cardEdited);
		});
	}
	// Delete
	else if (!card && cardId) {
		this.getBudgetHandler().getCardDao().remove(cardId, function(cardDeleted) {
			context.getEventHandler().handle(new ToastEvent("Card deleted"));
			if (callback)
				callback(cardDeleted);
		});
	}
};

BudgetMainController.prototype.handleTypeSave = function(type, typeId, callback) {
	var context = this;
	var budgetId = this.getBudgetHandler().getBudgetId();
	
	// New
	if (type && !typeId) {
		this.getBudgetHandler().getTypeDao().add(type, budgetId, function(typeAdded) {
			context.getEventHandler().handle(new ToastEvent("Type added"));
			if (callback)
				callback(typeAdded);
		});
	}
	// Edit
	else if (type && typeId) {
		this.getBudgetHandler().getTypeDao().edit(typeId, type, function(typeEdited) {
			context.getEventHandler().handle(new ToastEvent("Type edited"));
			if (callback)
				callback(typeEdited);
		});
	}
	// Delete
	else if (!type && typeId) {
		this.getBudgetHandler().getTypeDao().remove(typeId, function(typeDeleted) {
			context.getEventHandler().handle(new ToastEvent("Type deleted"));
			if (callback)
				callback(typeDeleted);
		});
	}
};

BudgetMainController.prototype.handleBudgetSave = function(budget, budgetId, callback) {
	var context = this;
	
	// New
	if (budget && !budgetId) {
		this.getBudgetHandler().getBudgetDao().add(budget, null, function(budgetAdded) {
			context.getEventHandler().handle(new ToastEvent("Budget added"));
			if (callback)
				callback(budgetAdded);
		});
	}
	// Edit
	else if (budget && budgetId) {
		this.getBudgetHandler().getBudgetDao().edit(budgetId, budget, function(budgetEdited) {
			context.getEventHandler().handle(new ToastEvent("Budget edited"));
			if (callback)
				callback(budgetEdited);
		});
	}
	// Delete
	else if (!budget && budgetId) {
		this.getBudgetHandler().getBudgetDao().remove(budgetId, function(budgetDeleted) {
			context.getEventHandler().handle(new ToastEvent("Budget deleted"));
			if (callback)
				callback(budgetDeleted);
		});
	}
};

BudgetMainController.prototype.handleBudgetUserSave = function(budgetUser, budgetUserObject, callback) {
	var context = this;
	var budgetId = this.getBudgetHandler().getBudgetId();
	
	// New
	if (budgetUser && !budgetUserObject) {
		this.getBudgetHandler().getBudgetDao().addUser(budgetId, budgetUser.email, function(budgetUserAdded) {
			context.getEventHandler().handle(new ToastEvent("Budget User added"));
			if (callback)
				callback(budgetUserAdded);
		});
	}
	// Delete
	else if (!budgetUser && budgetUserObject) {
		this.getBudgetHandler().getBudgetDao().removeUser(budgetId, budgetUserObject.id, budgetUserObject.email, function(budgetUserDeleted) {
			context.getEventHandler().handle(new ToastEvent("Budget User deleted"));
			if (callback)
				callback(budgetUserDeleted);
		});
	}
};

// ... /HANDLE

/**
 * @param {BudgetMainView}
 *            view
 */
BudgetMainController.prototype.render = function(view) {
	AbstractMainController.prototype.render.call(this, view);
	var context = this;

	// Budget id
	var budgetId = this.getHash().budget || null;

	// Retrieve budget
	this.getBudgetHandler().doRetrieveBudget(budgetId, function() {
		context.handleRequest(true);
	});

};

// /FUNCTIONS
