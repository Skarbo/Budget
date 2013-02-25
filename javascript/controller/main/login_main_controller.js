// CONSTRUCTOR
LoginMainController.prototype = new AbstractMainController();

/**
 * Budget Controller
 * 
 * @param {EventHandler}
 *            eventHandler
 */
function LoginMainController(eventHandler, mode, query) {
	AbstractMainController.apply(this, arguments);
}

// VARIABLES

// /VARIABLES

// FUNCTIONS

/**
 * @param {LoginMainView}
 *            view
 */
LoginMainController.prototype.render = function(view) {
	AbstractMainController.prototype.render.call(this, view);
};

// /FUNCTIONS
