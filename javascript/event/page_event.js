PageEvent.prototype = new Event();

function PageEvent(page, id) {
	this.page = page;
	this.id = id;
}

// VARIABLES

PageEvent.TYPE = "PageEvent";

// /VARIABLES

// FUNCTIONS

PageEvent.prototype.getPage = function() {
	return this.page;
};

PageEvent.prototype.getId = function() {
	return this.id;
};

PageEvent.prototype.getType = function() {
	return PageEvent.TYPE;
};

// /FUNCTIONS
