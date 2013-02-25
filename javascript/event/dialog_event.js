DialogEvent.prototype = new Event();

function DialogEvent(title, callback) {
	this.title = title;
	this.callback = callback;
}

// VARIABLES

DialogEvent.TYPE = "DialogEvent";

// /VARIABLES

// FUNCTIONS

DialogEvent.prototype.getTitle = function() {
	return this.title;
};

DialogEvent.prototype.getCallback = function() {
	return this.callback;
};

DialogEvent.prototype.getType = function() {
	return DialogEvent.TYPE;
};

// /FUNCTIONS
