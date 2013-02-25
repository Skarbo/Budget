BudgetEvent.prototype = new Event();

function BudgetEvent(id) {
	this.id = id;
}

// VARIABLES

BudgetEvent.TYPE = "BudgetEvent";

// /VARIABLES

// FUNCTIONS

BudgetEvent.prototype.getId = function() {
	return this.id;
};

BudgetEvent.prototype.getType = function() {
	return BudgetEvent.TYPE;
};

// /FUNCTIONS
