CloseOverlayEvent.prototype = new Event();

function CloseOverlayEvent(id) {
	this.id = id;
}

// VARIABLES

CloseOverlayEvent.TYPE = "CloseOverlayEvent";

// /VARIABLES

// FUNCTIONS

CloseOverlayEvent.prototype.getId = function() {
	return this.id;
};

CloseOverlayEvent.prototype.getType = function() {
	return CloseOverlayEvent.TYPE;
};

// /FUNCTIONS
