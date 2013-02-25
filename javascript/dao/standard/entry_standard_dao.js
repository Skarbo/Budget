// CONSTRUCTOR
EntryStandardDao.prototype = new AbstractStandardDao();

/**
 * @param {integer}
 *            mode
 */
function EntryStandardDao(mode) {
	AbstractStandardDao.call(this, mode, EntryStandardDao.CONTROLLER_NAME);
	this.foreignField = "budget_id";
	this.listMonths = [];
}

// VARIABLES

EntryStandardDao.CONTROLLER_NAME = "entry";

// /VARIABLES

// FUNCTIONS

EntryStandardDao.prototype.getMonth = function(budgetId, monthId, callback, forceAjax) {
	var context = this;
	var uri = Core.sprintf("month/%s/%s", monthId, budgetId);

	if (!forceAjax && jQuery.inArray(monthId, this.listMonths) > -1) {
		var monthList = this.getListAdapter().getFilteredList(function(entry) {
			return entry.monthId == monthId;
		});
		callback(monthList);
	} else {
		this.ajax.query(uri, function(single, list) {
			context.listMonths.push(monthId);
			context.getListAdapter().addAll(list);
			if (callback)
				callback(list);
		});
	}
};

// /FUNCTIONS
