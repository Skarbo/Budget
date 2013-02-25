OverlayEvent.prototype = new Event();

function OverlayEvent(id, options) {
	options = options || {};
	this.id = id;
	this.options = options;
}

// VARIABLES

OverlayEvent.TYPE = "OverlayEvent";

// /VARIABLES

// FUNCTIONS

OverlayEvent.prototype.getId = function() {
	return this.id;
};

OverlayEvent.prototype.getOptions = function() {
	return this.options;
};

OverlayEvent.prototype.getType = function() {
	return OverlayEvent.TYPE;
};

// /FUNCTIONS
