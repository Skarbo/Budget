SaveEntryBudgetEvent.prototype = new Event();

function SaveEntryBudgetEvent(entry, entryId) {
	this.entry = entry;
	this.entryId = entryId;
}

// VARIABLES

SaveEntryBudgetEvent.TYPE = "SaveEntryBudgetEvent";

// /VARIABLES

// FUNCTIONS

SaveEntryBudgetEvent.prototype.getEntry = function() {
	return this.entry;
};

SaveEntryBudgetEvent.prototype.getEntryId = function() {
	return this.entryId;
};

SaveEntryBudgetEvent.prototype.getType = function() {
	return SaveEntryBudgetEvent.TYPE;
};

// /FUNCTIONS
