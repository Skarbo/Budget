SaveEvent.prototype = new Event();

function SaveEvent(type, object, objectId, callback) {
	this.saveType = type;
	this.object = object;
	this.objectId = objectId;
	this.callback = callback;
}

// VARIABLES

SaveEvent.TYPE = "SaveEvent";

// /VARIABLES

// FUNCTIONS

SaveEvent.prototype.getSaveType = function() {
	return this.saveType;
};

SaveEvent.prototype.getObject = function() {
	return this.object;
};

SaveEvent.prototype.getObjectId = function() {
	return this.objectId;
};

SaveEvent.prototype.getCallback = function() {
	return this.callback;
};

SaveEvent.prototype.getType = function() {
	return SaveEvent.TYPE;
};

// /FUNCTIONS
