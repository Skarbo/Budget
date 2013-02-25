// CONSTRUCTOR
LoginMainView.prototype = new AbstractMainView();

function LoginMainView() {
	AbstractMainView.apply(this, arguments);
	this.actionbarPresenter = new ActionbarPresenterView(this);
}

// /CONSTRUCTOR

// VARIABLES

/**
 * @returns {ActionbarPresenterView}
 */
LoginMainView.prototype.getActionbarPresenter = function() {
	return this.actionbarPresenter;
};

LoginMainView.prototype.getActionbarWrapperElement = function() {
	return this.getWrapperElement().find(".actionbar_wrapper");
};

LoginMainView.prototype.getLoginWrapper = function() {
	return this.getWrapperElement().find(".login_wrapper");
};

LoginMainView.prototype.getLoginButtons = function() {
	return this.getLoginWrapper().find(".login_button");
};

// /VARIABLES

// FUNCTIONS

/**
 * @param {LoginMainController}
 *            controller
 */
LoginMainView.prototype.draw = function(controller) {
	AbstractMainView.prototype.draw.call(this, controller);
	
	this.getActionbarPresenter().draw(this.getActionbarWrapperElement());	
	this.getActionbarPresenter().doSetReferral(function(referralElement){
		var referral = referralElement.attr("data-referral");
		document.location.href = referral;
	});
	
	this.getLoginButtons().touchActive();
};

// /FUNCTIONS
