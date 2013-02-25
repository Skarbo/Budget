ChartloadEvent.prototype = new Event();

function ChartloadEvent() {
}

// VARIABLES

ChartloadEvent.TYPE = "ChartloadEvent";

// /VARIABLES

// FUNCTIONS

ChartloadEvent.prototype.getType = function() {
	return ChartloadEvent.TYPE;
};

// /FUNCTIONS
