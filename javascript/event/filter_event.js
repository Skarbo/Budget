FilterEvent.prototype = new Event();

function FilterEvent(options) {
	this.options = options;
}

// VARIABLES

FilterEvent.TYPE = "FilterEvent";

// /VARIABLES

// FUNCTIONS

FilterEvent.prototype.getOptions = function() {
	return this.options;
};

FilterEvent.prototype.getType = function() {
	return FilterEvent.TYPE;
};

// /FUNCTIONS
