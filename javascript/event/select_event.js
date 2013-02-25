SelectEvent.prototype = new Event();

function SelectEvent(type, id) {
	this.type = type;
	this.id = id;
}

// VARIABLES

SelectEvent.TYPE = "SelectEvent";

// /VARIABLES

// FUNCTIONS

SelectEvent.prototype.getId = function() {
	return this.id;
};

SelectEvent.prototype.getSelectType = function() {
	return this.type;
};

SelectEvent.prototype.getType = function() {
	return SelectEvent.TYPE;
};

// /FUNCTIONS
