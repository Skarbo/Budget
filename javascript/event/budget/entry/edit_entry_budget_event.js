EditEntryBudgetEvent.prototype = new Event();

function EditEntryBudgetEvent(entryId) {
	this.entryId = entryId;
}

// VARIABLES

EditEntryBudgetEvent.TYPE = "EditEntryBudgetEvent";

// /VARIABLES

// FUNCTIONS

EditEntryBudgetEvent.prototype.getEntryId = function() {
	return this.entryId;
};

EditEntryBudgetEvent.prototype.getType = function() {
	return EditEntryBudgetEvent.TYPE;
};

// /FUNCTIONS
