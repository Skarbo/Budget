// CONSTRUCTOR
TypeStandardDao.prototype = new AbstractStandardDao();

/**
 * @param {integer}
 *            mode
 */
function TypeStandardDao(mode) {
	AbstractStandardDao.call(this, mode, TypeStandardDao.CONTROLLER_NAME);
	this.foreignField = null;
}

// VARIABLES

TypeStandardDao.CONTROLLER_NAME = "type";

// /VARIABLES

// FUNCTIONS

// /FUNCTIONS
