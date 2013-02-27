// CONSTRUCTOR
EntryOverlayPresenterView.prototype = new OverlayPresenterView();

function EntryOverlayPresenterView(view, overlayId) {
	OverlayPresenterView.apply(this, arguments);
	this.mode = "new";
	this.entryId = null;
	this.entryLast = null;
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

EntryOverlayPresenterView.prototype.getHash = function() {
	return this.mode == "edit" ? $.extend({
		entry : this.entryId
	}, OverlayPresenterView.prototype.getHash.call(this)) : OverlayPresenterView.prototype.getHash.call(this);
};

// ... ... ELEMENT

EntryOverlayPresenterView.prototype.getHeaderElement = function() {
	return this.getRoot().find(".overlay_header");
};

EntryOverlayPresenterView.prototype.getFormElement = function() {
	return this.getRoot().find("#entry_form");
};

EntryOverlayPresenterView.prototype.getDateInputElement = function() {
	return this.getFormElement().find("input#entry_date");
};

EntryOverlayPresenterView.prototype.getCostInputElement = function() {
	return this.getFormElement().find("input[name=cost]");
};

EntryOverlayPresenterView.prototype.getCreditInputElement = function() {
	return this.getFormElement().find("input[name=credit]");
};

EntryOverlayPresenterView.prototype.getSingleInputElement = function() {
	return this.getFormElement().find("input[name=single]");
};

EntryOverlayPresenterView.prototype.getTabsElement = function() {
	return this.getRoot().find("#entry_new_tabs");
};

EntryOverlayPresenterView.prototype.getCalendarElement = function() {
	return this.getRoot().find("#entry_calendar");
};

EntryOverlayPresenterView.prototype.getCardSelectElement = function() {
	return this.getRoot().find(".select_wrapper#entry_card");
};

EntryOverlayPresenterView.prototype.getTypeSelectElement = function() {
	return this.getRoot().find(".select_wrapper#entry_type");
};

EntryOverlayPresenterView.prototype.getCostElement = function() {
	return this.getRoot().find(".cost_wrapper#entry_cost");
};

EntryOverlayPresenterView.prototype.getCommentElement = function() {
	return this.getRoot().find(".comment_wrapper#entry_comment");
};

EntryOverlayPresenterView.prototype.getCommentTextareaElement = function() {
	return this.getFormElement().find("textarea[name=comment]");
};

EntryOverlayPresenterView.prototype.getCommentButtonElement = function() {
	return this.getCommentElement().find(".entry_save_button");
};

EntryOverlayPresenterView.prototype.getDeleteButtonElement = function() {
	return this.getHeaderElement().find(".overlay_header_buttons_container .entry_delete");
};

// ... ... /ELEMENT

// ... /GET

// ... DO

EntryOverlayPresenterView.prototype.doBindEventHandler = function() {
	OverlayPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// Handle "Resize" event
	this.getEventHandler().registerListener(ResizeEvent.TYPE,
	/**
	 * @param {ResizeEvent}
	 *            event
	 */
	function(event) {
		if (context.isShown()) {
			context.getTabsElement().tabs();
		}
	});

	// /EVENTS

};

EntryOverlayPresenterView.prototype.doShow = function(entryId) {
	OverlayPresenterView.prototype.doShow.call(this);
	var context = this;
	this.entryId = entryId || null;
	this.mode = !this.entryId ? "new" : "edit";

	// Tabs
	this.getTabsElement().tabs({
		selectCallback : function(tab) {
			switch (tab) {
			case "comment":
				context.getCommentTextareaElement().focus();
				break;
			}
		}
	});
	// this.getTabsElement().tabs("tab", "card");
	this.getTabsElement().tabs("first");

	// Header
	if (this.mode == "new") {
		this.getHeaderElement().find(".overlay_header_title .new").removeClass("hide");
		this.getHeaderElement().find(".overlay_header_title .edit").addClass("hide");
	} else {
		this.getHeaderElement().find(".overlay_header_title .new").addClass("hide");
		this.getHeaderElement().find(".overlay_header_title .edit").removeClass("hide");
	}

	// Buttons
	if (this.mode == "new") {
		this.getDeleteButtonElement().addClass("hide").next().filter(".spacer").addClass("hide");
	} else {
		// Delete button
		this.getDeleteButtonElement().removeClass("hide").next().filter(".spacer").removeClass("hide");
		this.getDeleteButtonElement().unbind(".entry_overlay").bind("touchclick.entry_overlay", function(event) {
			if (!context.entryId)
				return console.warn("Can't delete entry, entry id not given");
			context.getEventHandler().handle(new DialogEvent("Delete Entry?", function() {
				console.log("Delete entry dialog OK");
				context.getEventHandler().handle(new SaveEvent("entry", null, context.entryId));
				context.doClose();
			}));
		});
	}

	// Edit
	if (this.mode == "edit") {
		this.getView().getBudgetHandler().getEntryDao().get(entryId, function(entry) {
			context.drawEntry(entry);
		});
	}
	// New
	else {
		this.drawEntry(null);
	}

};

EntryOverlayPresenterView.prototype.doClose = function() {
	OverlayPresenterView.prototype.doClose.call(this);

	this.getDeleteButtonElement().unbind(".entry_overlay");
};

// ... /DO

// ... HANDLE

EntryOverlayPresenterView.prototype.handleEntrySave = function() {
	var entryForm = this.getFormElement();
	var entry = entryForm.serializeJSON();
	var entryRequired = [ "date", "card", "type", "cost" ];
	var illegal = "";

	for ( var i in entryRequired) {
		if (entry[entryRequired[i]] == "")
			illegal = "Entry \"" + entryRequired[i] + "\" not given";
	}

	if (!illegal && entry.type == "_new" && entry.type_title == "")
		illegal = entry.type_title == "" ? "Empty new type title" : "";

	if (!illegal && entry.card == "_new" && entry.card_title == "")
		illegal = entry.card_title == "" ? "Empty new card title" : "";

	if (illegal != "")
		this.getEventHandler().handle(new ToastEvent(illegal, ToastEvent.LENGTH_LONG));
	else {
		this.getEventHandler().handle(new SaveEvent("entry", entry, this.mode == "edit" ? this.entryId : null));
		this.entryLast = entry;
	}

	return illegal == "";
};

EntryOverlayPresenterView.prototype.handleCancel = function() {
	OverlayPresenterView.prototype.handleCancel.call(this);
};

EntryOverlayPresenterView.prototype.handleOk = function() {
	var ok = OverlayPresenterView.prototype.handleOk.call(this);
	var okEntry = this.handleEntrySave();
	return ok && okEntry;
};

// ... /HANDLE

EntryOverlayPresenterView.prototype.drawEntry = function(entry) {
	var context = this;
	entry = entry || {};

	// Reset form
	if (this.mode == "new") {
		this.getDateInputElement().val(this.entryLast ? this.entryLast.date : "");
		this.getCostInputElement().val("");
		this.getCreditInputElement().prop("checked", false);
		this.getSingleInputElement().prop("checked", false);
		this.getCommentTextareaElement().val("");
	} else {
		this.getDateInputElement().val((new Date(entry.date * 1000)).format("yyyy-mm-dd"));
		this.getCostInputElement().val(entry.cost);
		this.getCreditInputElement().prop("checked", entry.credit == 1);
		this.getSingleInputElement().prop("checked", entry.single == 1);
		this.getCommentTextareaElement().val(entry.comment);
	}

	// DATE

	// Calendar
	this.getCalendarElement().calendar({
		selectCallback : function(date) {
			context.getTabsElement().tabs("next");
		}
	});

	// /DATE

	// CARD

	var cards = this.getView().getBudgetHandler().getCards().getArray();
	cards.sort(function(left, right) {
		if (left.title == right.title) {
			return 0;
		}
		return (left.title < right.title) ? -1 : 1;
	});
	var cardsOptions = [];
	for ( var i in cards)
		cardsOptions.push({
			value : cards[i].id,
			text : $("<span />", {
				text : cards[i].title
			}).after($("<span />", {
				text : cards[i].number
			}))
		});

	this.getCardSelectElement().select({
		selected : entry.card,
		options : cardsOptions,
		selectCallback : function(value) {
			context.getTabsElement().tabs("next");
		}
	});

	// /CARD

	// TYPE

	var types = this.getView().getBudgetHandler().getTypes().getArray();
	types.sort(function(left, right) {
		if (left.title == right.title) {
			return 0;
		}
		return (left.title < right.title) ? -1 : 1;
	});
	var typesOptions = [];
	for ( var i in types)
		typesOptions.push({
			value : types[i].id,
			text : types[i].title
		});

	this.getTypeSelectElement().select({
		selected : entry.type,
		options : typesOptions,
		selectCallback : function(value) {
			context.getTabsElement().tabs("next");
		}
	});

	// /TYPE

	// COST

	this.getCostElement().cost({
		equalCallback : function() {
			context.getTabsElement().tabs("next");
		}
	});

	// /COST

	// COMMENT

	this.getCommentButtonElement().unbind(".comment").bind("touchclick.comment", function(event) {
		context.doClose(true);
	});

	// /COMMENT

};

// /FUNCTIONS
