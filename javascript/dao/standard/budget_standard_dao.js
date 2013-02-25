// CONSTRUCTOR
BudgetStandardDao.prototype = new AbstractStandardDao();

/**
 * @param {integer}
 *            mode
 */
function BudgetStandardDao(mode) {
	AbstractStandardDao.call(this, mode, BudgetStandardDao.CONTROLLER_NAME);
	this.foreignField = null;
}

// VARIABLES

BudgetStandardDao.CONTROLLER_NAME = "budget";

// /VARIABLES

// FUNCTIONS

BudgetStandardDao.prototype.addUser = function(budgetId, userEmail, callback) {
	var context = this;
	var uri = Core.sprintf("useradd/%s", budgetId);

	this.ajax.post(uri, {
		user_email : userEmail
	}, function(single, list) {
		context.getListAdapter().add(single.id, single);
		if (callback)
			callback(single);
	});
};

BudgetStandardDao.prototype.removeUser = function(budgetId, userId, userEmail, callback) {
	var context = this;
	userId = userId || null;
	userEmail = userEmail || null;
	var uri = Core.sprintf("userremove/%s", budgetId);

	this.ajax.post(uri, {
		"user_id" : userId,
		"user_email" : userEmail
	}, function(single, list) {
		context.getListAdapter().add(single.id, single);
		if (callback)
			callback(single);
	});
};

// /FUNCTIONS
