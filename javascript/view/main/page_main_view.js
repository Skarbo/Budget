// CONSTRUCTOR
PageMainView.prototype = new AbstractPageMainView();

function PageMainView(view) {
	AbstractPageMainView.apply(this, arguments);
	this.visible = false;
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {BudgetHandler}
 */
PageMainView.prototype.getBudgetHandler = function() {
	return this.getView().getController().getBudgetHandler();
};

/**
 * @returns {BudgetMainView}
 */
PageMainView.prototype.getView = function() {
	return AbstractPageMainView.prototype.getView.call(this);
};

/**
 * @returns {ActionbarPresenterView}
 */
PageMainView.prototype.getActionbarPresenter = function() {
	return this.getView().getActionbarPresenter();
};

// ... /GET

// ... IS

/**
 * @returns {boolean}
 */
PageMainView.prototype.isVisible = function() {
	return this.visible;
};

// ... /IS

PageMainView.prototype.show = function() {
	this.getRoot().removeClass("hide");
	this.visible = true;
};

PageMainView.prototype.hide = function() {
	this.getRoot().addClass("hide");
	this.visible = false;
};

// /FUNCTIONS
