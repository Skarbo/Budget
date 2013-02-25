// CONSTRUCTOR
SettingsOverlayPresenterView.prototype = new OverlayPresenterView();

function SettingsOverlayPresenterView(view, overlayId) {
	OverlayPresenterView.apply(this, arguments);
	this.budgetsSettingsEditBudgetTemplate = null;
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

// ... ... ELEMENT

SettingsOverlayPresenterView.prototype.getTabsElement = function() {
	return this.getRoot().find(".tabs_wrapper");
};

SettingsOverlayPresenterView.prototype.getCardsEditSettingsElement = function() {
	return this.getRoot().find("#cards_edit_settings.edit_settings_wrapper");
};

SettingsOverlayPresenterView.prototype.getTypesEditSettingsElement = function() {
	return this.getRoot().find("#types_edit_settings.edit_settings_wrapper");
};

SettingsOverlayPresenterView.prototype.getBudgetsSettingsElement = function() {
	return this.getRoot().find("#budgets_settings");
};

// ... ... ... BUDGETS EDIT

SettingsOverlayPresenterView.prototype.getBudgetsSettingsEditsElement = function() {
	return this.getBudgetsSettingsElement().find("#budgets_edit");
};

SettingsOverlayPresenterView.prototype.getBudgetsSettingsEditsEditTemplateElement = function() {
	return this.getBudgetsSettingsEditsElement().find(".budgets_budget_row.edit.template");
};

SettingsOverlayPresenterView.prototype.getBudgetsSettingsEditsEditElement = function() {
	return this.getBudgetsSettingsEditsElement().find(".budgets_budget_row.edit:NOT(.template)");
};

SettingsOverlayPresenterView.prototype.getBudgetsSettingsEditsEditBudgetElement = function(budgetId) {
	return this.getBudgetsSettingsEditsEditElement().filter("[data-budget=" + budgetId + "]");
};

SettingsOverlayPresenterView.prototype.getBudgetsSettingsEditsAddElement = function() {
	return this.getBudgetsSettingsEditsElement().find(".budgets_budget_row.new");
};

// ... ... ... /BUDGETS EDIT

// ... ... ... BUDGETS USERS

SettingsOverlayPresenterView.prototype.getBudgetsSettingsUsersElement = function() {
	return this.getBudgetsSettingsElement().find("#budgets_users");
};

SettingsOverlayPresenterView.prototype.getBudgetsSettingsUsersWrapperElement = function() {
	return this.getBudgetsSettingsUsersElement().find(".budgets_user_wrapper");
};

SettingsOverlayPresenterView.prototype.getBudgetsSettingsUsersShowRowElement = function() {
	return this.getBudgetsSettingsUsersWrapperElement().find(".budgets_user_show_row:NOT(.template)");
};

SettingsOverlayPresenterView.prototype.getBudgetsSettingsUsersShowRowTemplateElement = function() {
	return this.getBudgetsSettingsUsersWrapperElement().find(".budgets_user_show_row.template");
};

SettingsOverlayPresenterView.prototype.getBudgetsSettingsUsersAddElement = function() {
	return this.getBudgetsSettingsUsersWrapperElement().find(".budgets_user_add_row");
};

// ... ... ... /BUDGETS USERS

// ... ... /ELEMENT

// ... /GET

// ... DO

SettingsOverlayPresenterView.prototype.doBindEventHandler = function() {
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

	// LIST ADAPTERS

	this.getView().getBudgetHandler().getBudgets().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "add":
			context.drawBudgetsSettingsBudget(object);
			break;

		case "addall":
			context.drawBudgetsSettingsBudgets(object);
			break;
		}
	});

	this.getView().getBudgetHandler().getCards().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "addall":
			context.doCardsAdd(object);
			break;

		case "clear":
			context.doCardsAdd({});
			break;
		}
	});

	this.getView().getBudgetHandler().getTypes().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "addall":
			context.doTypesAdd(object);
			break;

		case "clear":
			context.doTypesAdd({});
			break;
		}
	});

	// /LIST ADAPTERS

	// BUDGETS SETTINGS

	this.getBudgetsSettingsEditsElement().unbind(".budgets_settings").bind("touchclick.budgets_settings", function(event) {
		var target = $(event.target);
		var budgetRow = target.closest(".budgets_budget_row");
		var isEdit = budgetRow.is(".edit");
		var budgetId = budgetRow.attr("data-budget");
		var selectElement = target.closest(".budget_select");
		var editElement = target.closest(".budget_edit");
		var deleteElement = target.closest(".budget_delete");
		var addElement = target.closest(".budget_add");

		// Select
		if (isEdit && selectElement.length > 0 && budgetId) {
			context.doBudgetsSettingsBudgetSelect(budgetId);
		}
		// Edit
		else if (isEdit && editElement.length > 0 && budgetId) {
			context.doBudgetsSettingsBudgetEdit(budgetId);
		}
		// Delete
		else if (isEdit && deleteElement.length > 0 && budgetId) {
			context.doBudgetsSettingsBudgetDelete(budgetId);
		}
		// Add
		else if (!isEdit && addElement.length > 0) {
			context.doBudgetsSettingsBudgetAdd();
		}
	});

	this.getBudgetsSettingsUsersWrapperElement().unbind(".budgets_settings").bind("touchclick.budgets_settings", function(event) {
		var target = $(event.target);
		var isAdd = target.is(".budgets_user_add");
		var isDelete = target.is(".budgets_user_delete");

		if (isAdd) {
			context.doBudgetsSettingsBudgetUserAdd();
		} else if (isDelete) {
			context.doBudgetsSettingsBudgetUserDelete(target.closest(".budgets_user_show_row"));
		}
	});

	// /BUDGETS SETTINGS
};

SettingsOverlayPresenterView.prototype.doCardsAdd = function(cards) {
	this.getCardsEditSettingsElement().editSettings("clear");
	for ( var cardId in cards)
		this.getCardsEditSettingsElement().editSettings("add", cards[cardId]);
};

SettingsOverlayPresenterView.prototype.doTypesAdd = function(types) {
	this.getTypesEditSettingsElement().editSettings("clear");
	for ( var typeId in types)
		this.getTypesEditSettingsElement().editSettings("add", types[typeId]);
};

// ... /DO

// ... HANDLE

SettingsOverlayPresenterView.prototype.handleCancel = function() {
	OverlayPresenterView.prototype.handleCancel.call(this);
};

// ... /HANDLE

// ... DO

SettingsOverlayPresenterView.prototype.doShow = function() {
	OverlayPresenterView.prototype.doShow.call(this);
	var context = this;

	// Tabs
	this.getTabsElement().tabs();

};

SettingsOverlayPresenterView.prototype.doBefore = function(root) {
	OverlayPresenterView.prototype.doBefore.call(this, root);
	var context = this;

	this.budgetsSettingsEditBudgetTemplate = this.getBudgetsSettingsEditsEditTemplateElement().clone().removeClass("template");

	// CARDS

	// var cards = this.getView().getBudgetHandler().getCards().getAll();
	this.getCardsEditSettingsElement().editSettings({
		addCallback : function(card, template) {
			template.attr("data-card", card.id);
			template.find("input[name=card_title]").val(card.title);
			template.find("input[name=card_number]").val(card.number);
		},
		newCallback : function(settingElement) {
			var card = {};
			card.title = settingElement.find("input[name=card_title]").val();
			card.number = settingElement.find("input[name=card_number]").val();
			var valid = card.title != "";
			if (valid) {
				context.getEventHandler().handle(new SaveEvent("card", card, null, function(card) {
					context.getCardsEditSettingsElement().editSettings("add", card, true);
				}));
				context.getEventHandler().handle(new ToastEvent("Adding Card"));
			}
			return valid;
		},
		editCallback : function(settingElement) {
			var cardId = settingElement.attr("data-card");
			var card = {};
			card.title = settingElement.find("input[name=card_title]").val();
			card.number = settingElement.find("input[name=card_number]").val();
			var valid = card.title != "";
			if (valid) {
				context.getEventHandler().handle(new SaveEvent("card", card, cardId));
				context.getEventHandler().handle(new ToastEvent("Editing Card"));
			}
			return valid;
		},
		deleteCallback : function(settingElement, deleteFunction) {
			var cardId = settingElement.attr("data-card");
			var title = settingElement.find("input[name=card_title]").val();
			if (cardId) {
				context.getEventHandler().handle(new DialogEvent("Delete Card \"" + title + "\"?", function() {
					context.getEventHandler().handle(new SaveEvent("card", null, cardId, deleteFunction));
					context.getEventHandler().handle(new ToastEvent("Deleting Card"));
				}));
			}
		}
	});
	// for ( var cardId in cards)
	// this.getCardsEditSettingsElement().editSettings("add", cards[cardId]);

	// /CARDS

	// TYPES

	// var types = this.getView().getBudgetHandler().getTypes().getAll();
	this.getTypesEditSettingsElement().editSettings({
		addCallback : function(type, template) {
			template.attr("data-type", type.id);
			template.find("input[name=type_title]").val(type.title);
		},
		newCallback : function(settingElement) {
			var type = {};
			type.title = settingElement.find("input[name=type_title]").val();
			var valid = type.title != "";
			if (valid) {
				context.getEventHandler().handle(new SaveEvent("type", type, null, function(type) {
					context.getTypesEditSettingsElement().editSettings("add", type, true);
				}));
				context.getEventHandler().handle(new ToastEvent("Adding Type"));
			}
			return valid;
		},
		editCallback : function(settingElement) {
			var typeId = settingElement.attr("data-type");
			var type = {};
			type.title = settingElement.find("input[name=type_title]").val();
			var valid = type.title != "";
			if (valid) {
				context.getEventHandler().handle(new SaveEvent("type", type, typeId));
				context.getEventHandler().handle(new ToastEvent("Editing Type"));
			}
			return valid;
		},
		deleteCallback : function(settingElement, deleteFunction) {
			var typeId = settingElement.attr("data-type");
			var title = settingElement.find("input[name=type_title]").val();
			if (typeId) {
				context.getEventHandler().handle(new DialogEvent("Delete Type \"" + title + "\"?", function() {
					context.getEventHandler().handle(new SaveEvent("type", null, typeId, deleteFunction));
					context.getEventHandler().handle(new ToastEvent("Deleting Type"));
				}));
			}
			return !(!typeId);
		}
	});
	// for ( var typeId in types)
	// this.getTypesEditSettingsElement().editSettings("add", types[typeId]);

	// /TYPES
};

SettingsOverlayPresenterView.prototype.doBudgetsSettingsBudgetSelect = function(budgetId, isDontChange) {
	this.getBudgetsSettingsEditsEditElement().removeClass("selected");
	var budgetRow = this.getBudgetsSettingsEditsEditBudgetElement(budgetId);
	if (budgetRow.length > 0) {
		budgetRow.addClass("selected");
		if (!isDontChange) {
			this.getEventHandler().handle(new BudgetEvent(budgetId));
		}
	}
};

SettingsOverlayPresenterView.prototype.doBudgetsSettingsBudgetEdit = function(budgetId) {
	var budgetRow = this.getBudgetsSettingsEditsEditBudgetElement(budgetId);
	if (budgetRow.length > 0) {
		var budgetTitle = budgetRow.find("input[name=budget_title]").val();
		this.getEventHandler().handle(new ToastEvent("Editing Budget"));
		this.getEventHandler().handle(new SaveEvent("budget", {
			title : budgetTitle
		}, budgetId));
	}
};

SettingsOverlayPresenterView.prototype.doBudgetsSettingsBudgetDelete = function(budgetId) {
	var budgetRow = this.getBudgetsSettingsEditsEditBudgetElement(budgetId);
	var context = this;

	var budget = this.getView().getBudgetHandler().getBudgets().getItem(budgetId);

	if (!budget) {
		this.getEventHandler().handle(new ToastEvent("Budget dosen't exist"));
		return;
	}

	if (this.getView().getBudgetHandler().getBudgets().size() == 1) {
		this.getEventHandler().handle(new ToastEvent("Can't remove the last Budget"));
		return;
	}

	if (budgetRow.length > 0) {
		var budgetIdSelected = this.getView().getBudgetHandler().getBudgetId();
		if (budgetIdSelected == budgetId) {
			this.getEventHandler().handle(new ToastEvent("Can't delete selected Budget"));
		} else {
			this.getEventHandler().handle(new DialogEvent("Delete Budget \"" + budget.title + "\"?", function() {
				context.getEventHandler().handle(new ToastEvent("Deleting Budget"));
				context.getEventHandler().handle(new SaveEvent("budget", null, budgetId, function() {
					budgetRow.fadeOut();
				}));
			}));
		}
	}
};

SettingsOverlayPresenterView.prototype.doBudgetsSettingsBudgetAdd = function() {
	var budgetRow = this.getBudgetsSettingsEditsAddElement();
	if (budgetRow.length > 0) {
		var budgetTitle = budgetRow.find("input[name=budget_title]").val();
		this.getEventHandler().handle(new ToastEvent("Adding Budget"));
		this.getEventHandler().handle(new SaveEvent("budget", {
			title : budgetTitle
		}, null, function() {
			budgetRow.find("input[name=budget_title]").val("");
		}));
	}
};

SettingsOverlayPresenterView.prototype.doBudgetsSettingsBudgetUserAdd = function() {
	var usersAddElement = this.getBudgetsSettingsUsersAddElement();
	var userEmail = usersAddElement.find("input[name=budget_user_email]").val();
	if (userEmail) {
		this.getEventHandler().handle(new ToastEvent("Adding Budget User"));
		this.getEventHandler().handle(new SaveEvent("budget_user", {
			email : userEmail
		}, null, function() {
			usersAddElement.find("input[name=budget_user_email]").val("");
		}));
	}
};

SettingsOverlayPresenterView.prototype.doBudgetsSettingsBudgetUserDelete = function(userElement) {
	var context = this;
	var userEmail = userElement.attr("data-email") || null;
	var userId = userElement.attr("data-user") || null;

	var budetId = this.getView().getBudgetHandler().getBudgetId();
	var budget = this.getView().getBudgetHandler().getBudgets().getItem(budetId);
	if (budget.users.length == 1) {
		this.getEventHandler().handle(new ToastEvent("Can't delete the last Budget User"));
		return;
	}

	if (userEmail || userId) {
		this.getEventHandler().handle(new DialogEvent("Delete Budget User?", function() {
			context.getEventHandler().handle(new ToastEvent("Deleting Budget User"));
			context.getEventHandler().handle(new SaveEvent("budget_user", null, {
				email : userEmail,
				id : userId
			}, function() {
				userElement.fadeOut();
			}));
		}));

	}
};

// ... /DO

// ... DRAW

SettingsOverlayPresenterView.prototype.drawBudgetsSettingsBudgets = function(budgets) {
	this.getBudgetsSettingsEditsEditElement().remove();

	for ( var i in budgets) {
		this.drawBudgetsSettingsBudget(budgets[i]);
	}
	
	var budgetId = this.getView().getBudgetHandler().getBudgetId();
	this.doBudgetsSettingsBudgetSelect(budgetId, true);
};

SettingsOverlayPresenterView.prototype.drawBudgetsSettingsBudget = function(budget) {
	var budgetEditElement = this.getBudgetsSettingsEditsEditBudgetElement(budget.id);
	if (budgetEditElement.length == 0) {
		budgetEditElement = this.budgetsSettingsEditBudgetTemplate.clone();
		this.getBudgetsSettingsEditsAddElement().before(budgetEditElement);
	}

	budgetEditElement.attr("data-budget", budget.id);
	budgetEditElement.find("input[name=budget_title]").val(budget.title);

	var budgetId = this.getView().getBudgetHandler().getBudgetId();
	if (budgetId == budget.id) {
		this.drawBudgetsSettingsBudgetUsers(budget.users);
	}
};

SettingsOverlayPresenterView.prototype.drawBudgetsSettingsBudgetUsers = function(budgetUsers) {
	var userShowTemplate = this.getBudgetsSettingsUsersShowRowTemplateElement().clone().removeClass("template");

	this.getBudgetsSettingsUsersShowRowElement().remove();

	var userArray = null, userDate = null, userShow = null;
	for ( var i in budgetUsers) {
		userShow = userShowTemplate.clone();
		userArray = budgetUsers[i];
		userDate = userArray[3] ? new Date(userArray[3] * 1000) : null;

		userShow.attr("data-email", userArray[0] || null);
		userShow.attr("data-id", userArray[1] || null);
		userShow.find(".budgets_user_email").text(userArray[2] ? userArray[2] : (userArray[0] || ""));
		// userShow.find(".budgets_user_name").text(userArray[2] || "");
		// userShow.find(".budgets_user_loggedin").text(userDate ?
		// userDate.format("HH:MM d. mmm") : "");
		userShow.attr("title", userDate ? "Last login: " + userDate.format("HH:MM d. mmm yy") : "");
		userShow.find(".budgets_user_name").text("");
		userShow.find(".budgets_user_loggedin").text("");

		this.getBudgetsSettingsUsersAddElement().before(userShow);
	}

	this.getBudgetsSettingsUsersAddElement().find("input").val("");
};

SettingsOverlayPresenterView.prototype.draw = function(root) {
	OverlayPresenterView.prototype.draw.call(this, root);

};

// ... /DRAW

// /FUNCTIONS
