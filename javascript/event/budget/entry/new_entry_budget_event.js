NewEntryBudgetEvent.prototype = new Event();

function NewEntryBudgetEvent() {

}

// VARIABLES

NewEntryBudgetEvent.TYPE = "NewEntryBudgetEvent";

// /VARIABLES

// FUNCTIONS

NewEntryBudgetEvent.prototype.getType = function() {
	return NewEntryBudgetEvent.TYPE;
};

// /FUNCTIONS
