// CONSTRUCTOR
BudgetMainView.prototype = new AbstractMainView();

/**
 * Budget Main View
 * 
 */
function BudgetMainView() {
	AbstractMainView.apply(this, arguments);
	this.actionbarPresenter = new ActionbarPresenterView(this);
	this.budgetPage = new BudgetPageMainView(this);
	this.monthPage = new MonthPageMainView(this);
	this.entryOverlay = new EntryOverlayPresenterView(this, "entry");
	this.settingsOverlay = new SettingsOverlayPresenterView(this, "settings");
	this.toastOverlay = new OverlayPresenterView(this, "toast");
	this.toastTimeout = null;
	this.dialogOverlay = new OverlayPresenterView(this, "dialog");
	this.resizeTimer = null;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {ActionbarPresenterView}
 */
BudgetMainView.prototype.getActionbarPresenter = function() {
	return this.actionbarPresenter;
};

/**
 * @returns {BudgetPageMainView}
 */
BudgetMainView.prototype.getBudgetPage = function() {
	return this.budgetPage;
};

/**
 * @returns {MonthPageMainView}
 */
BudgetMainView.prototype.getMonthPage = function() {
	return this.monthPage;
};

/**
 * @returns {EntryOverlayPresenterView}
 */
BudgetMainView.prototype.getEntryOverlay = function() {
	return this.entryOverlay;
};

/**
 * @returns {SettingsOverlayPresenterView}
 */
BudgetMainView.prototype.getSettingsOverlay = function() {
	return this.settingsOverlay;
};

/**
 * @returns {OverlayPresenterView}
 */
BudgetMainView.prototype.getToastOverlay = function() {
	return this.toastOverlay;
};

/**
 * @returns {OverlayPresenterView}
 */
BudgetMainView.prototype.getDialogOverlay = function() {
	return this.dialogOverlay;
};

/**
 * @returns {BudgetHandler}
 */
BudgetMainView.prototype.getBudgetHandler = function() {
	return this.getController().getBudgetHandler();
};

// ... ... ELEMENT

BudgetMainView.prototype.getActionbarWrapperElement = function() {
	return this.getWrapperElement().find(".actionbar_wrapper");
};

BudgetMainView.prototype.getPageWrapperElement = function() {
	return this.getWrapperElement().find("#page_wrapper");
};

BudgetMainView.prototype.getBudgetPageWrapperElement = function() {
	return this.getPageWrapperElement().find("#budget_page_wrapper");
};

BudgetMainView.prototype.getMonthPageWrapperElement = function() {
	return this.getPageWrapperElement().find("#month_page_wrapper");
};

BudgetMainView.prototype.getEntryOverlayWrapperElement = function() {
	return this.getWrapperElement().find("#entry_overlay.overlay_wrapper");
};

BudgetMainView.prototype.getToastOverlayWrapperElement = function() {
	return this.getWrapperElement().find("#toast_overlay.overlay_wrapper");
};

BudgetMainView.prototype.getOverlayElement = function(overlayId) {
	return this.getWrapperElement().find(".overlay_wrapper#" + overlayId + "_overlay");
};

// ... ... /ELEMENT

// ... /GET

// ... DO

BudgetMainView.prototype.doBindEventHandler = function() {
	AbstractMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// Handle "Overlay" event
	this.getEventHandler().registerListener(OverlayEvent.TYPE,
	/**
	 * @param {OverlayEvent}
	 *            event
	 */
	function(event) {
		context.handleOverlay(event.getId());
	});
	this.getEventHandler().registerListener(CloseOverlayEvent.TYPE,
	/**
	 * @param {CloseOverlayEvent}
	 *            event
	 */
	function(event) {
		context.handleOverlayClose(event.getId());
	});

	// Handle "New Entry" event
	this.getEventHandler().registerListener(NewEntryBudgetEvent.TYPE,
	/**
	 * @param {NewEntryBudgetEvent}
	 *            event
	 */
	function(event) {
		context.doEntryNew();
	});

	// Handle "Edit Entry" event
	this.getEventHandler().registerListener(EditEntryBudgetEvent.TYPE,
	/**
	 * @param {EditEntryBudgetEvent}
	 *            event
	 */
	function(event) {
		context.doEntryEdit(event.getEntryId());
	});

	// Handle "Page" event
	this.getController().getEventHandler().registerListener(PageEvent.TYPE,
	/**
	 * @param {PageEvent}
	 *            event
	 */
	function(event) {
		context.handlePage(event.getPage());
	});

	// Handle "Toast" event
	this.getController().getEventHandler().registerListener(ToastEvent.TYPE,
	/**
	 * @param {ToastEvent}
	 *            event
	 */
	function(event) {
		context.handleToast(event.getMessage(), event.getLength());
	});

	// Handle "Dialog" event
	this.getController().getEventHandler().registerListener(DialogEvent.TYPE,
	/**
	 * @param {DialogEvent}
	 *            event
	 */
	function(event) {
		context.handleDialog(event.getTitle(), event.getCallback());
	});

	// /EVENTS

	// Handle orientation event
	// $(document).ready(
	// function() {
	// function reorient(e) {
	// var portrait = (window.orientation % 180 == 0);
	// $("body").addClass(portrait ? "portrait" : "landscape");
	// $("body").removeClass(portrait ? "landscape" : "portrait");
	// }
	// window.onorientationchange = reorient;
	// window.setTimeout(reorient, 0);
	// });

};

BudgetMainView.prototype.doEntryNew = function() {
	this.getEntryOverlay().doShow();
};

BudgetMainView.prototype.doEntryEdit = function(entryId) {
	this.getEntryOverlay().doShow(entryId);
};

// ... /DO

// ... HANDLE

BudgetMainView.prototype.handleOverlay = function(overlayId) {
	switch (overlayId) {
	case "entry":
		this.getEntryOverlay().doShow();
		break;

	case "settings":
		this.getSettingsOverlay().doShow();
		break;

	default:
		console.error("Overlay \"" + overlayId + "\" does not exist");
		break;
	}
};

BudgetMainView.prototype.handleOverlayClose = function(overlayId) {
	switch (overlayId) {
	case "entry":
		this.getEntryOverlay().doClose();
		break;

	case "settings":
		this.getSettingsOverlay().doClose();
		break;

	default:
		console.error("Overlay \"" + overlayId + "\" does not exist");
	}
};

BudgetMainView.prototype.handlePage = function(page) {
	this.getBudgetPage().hide();
	this.getMonthPage().hide();

	switch (page) {
	case "month":
		var monthId = this.getController().getHash().month;
		if (monthId)
			this.getMonthPage().show(monthId);
		else
			this.getBudgetPage().show();
		break;

	default:
		this.getBudgetPage().show();
		break;
	}
};

BudgetMainView.prototype.handleToast = function(message, length) {
	var context = this;
	this.getToastOverlay().getContentElement().find(".toast_message").text(message);
	this.getToastOverlay().doShow();

	if (this.toastTimeout)
		clearTimeout(this.toastTimeout);
	this.toastTimeout = setTimeout(function() {
		context.getToastOverlay().doClose();
		context.toastTimeout = null;
	}, length == ToastEvent.LENGTH_LONG ? 6000 : 3000);
};

BudgetMainView.prototype.handleDialog = function(title, callback) {
	this.getDialogOverlay().getRoot().find(".dialog_content").text(title);
	if (callback) {
		this.getDialogOverlay().setOkHandle(function() {
			callback();
			return true;
		});
	}
	this.getDialogOverlay().doShow();
};

// ... /HANDLE

BudgetMainView.prototype.doFitToPage = function() {
	this.getPageWrapperElement().height(
			$(window).height() - this.getPageWrapperElement().offset().top - (this.getPageWrapperElement().outerHeight(true) - this.getPageWrapperElement().height()));
};

BudgetMainView.prototype.before = function() {
	AbstractMainView.prototype.before.call(this);

	this.getToastOverlay().setBindClose(false);
	this.getToastOverlay().setHash(false);

	this.getDialogOverlay().setHash(false);
	this.getDialogOverlay().setBindClose(false);
};

/**
 * @param {BudgetMainController}
 *            controller
 */
BudgetMainView.prototype.draw = function(controller) {
	AbstractMainView.prototype.draw.call(this, controller);
	var context = this;

	// this.getWrapperElement().find(".tabs_wrapper").tabs();
	this.getActionbarPresenter().draw(this.getActionbarWrapperElement());

	this.getBudgetPage().draw(this.getBudgetPageWrapperElement());
	this.getMonthPage().draw(this.getMonthPageWrapperElement());

	this.getEntryOverlay().draw(this.getEntryOverlayWrapperElement());
	this.getSettingsOverlay().draw(this.getOverlayElement(this.getSettingsOverlay().getId()));
	this.getToastOverlay().draw(this.getToastOverlayWrapperElement());

	// DIALOG

	this.getDialogOverlay().draw(this.getOverlayElement(this.getDialogOverlay().getId()));
	this.getDialogOverlay().getRoot().find(".dialog_cancel").unbind(".dialog").bind("touchclick.dialog", function() {
		context.getDialogOverlay().doClose();
	});
	this.getDialogOverlay().getRoot().find(".dialog_ok").unbind(".dialog").bind("touchclick.dialog", function() {
		context.getDialogOverlay().doClose(true);
	});
	this.getDialogOverlay().getRoot().find(".dialog_cancel,.dialog_ok").touchActive();

	// /DIALOG

	// RESIZE

	$(window).resize(function() {
		// context.doFitToPage();
		clearTimeout(context.resizeTimer);
		context.resizeTimer = setTimeout(function() {
			context.getEventHandler().handle(new ResizeEvent());
		}, 100);
	});

	// this.doFitToPage();

	// /RESIZE
	
};

// /FUNCTIONS
