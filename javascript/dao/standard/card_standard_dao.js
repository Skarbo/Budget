// CONSTRUCTOR
CardStandardDao.prototype = new AbstractStandardDao();

/**
 * @param {integer}
 *            mode
 */
function CardStandardDao(mode) {
	AbstractStandardDao.call(this, mode, CardStandardDao.CONTROLLER_NAME);
	this.foreignField = null;
}

// VARIABLES

CardStandardDao.CONTROLLER_NAME = "card";

// /VARIABLES

// FUNCTIONS

// /FUNCTIONS
