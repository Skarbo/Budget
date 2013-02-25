<?php

class BudgetMainView extends MainView
{

    // VARIABLES


    public static $ID_BUDGET_PAGE_WRAPPER = "page_wrapper";

    /**
     * @var BudgetPageMainView
     */
    private $budgetPage;
    /**
     * @var MonthPageMainView
     */
    private $monthPage;
    /**
     * @var EntryOverlayPresenterView
     */
    private $entryOverlay;
    /**
     * @var OverlayPresenterView
     */
    private $dialogOverlay;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractView::getController()
     * @return BudgetMainController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see AbstractView::getLastModified()
     */
    public function getLastModified()
    {
        return filemtime( __FILE__ );
    }

    // ... /GET


    // ... CREATE


    /**
     * @return AbstractXhtml
     */
    private function createEditSettings( $id, AbstractXhtml $field )
    {
        $wrapper = Xhtml::div()->class_( "edit_settings_wrapper" )->id( $id );

        $editWrapper = Xhtml::div()->class_( "setting_wrapper", "edit", "template" );
        $editWrapper->addContent( Xhtml::div( "" )->attr( "data-icon", "edit" )->class_( "edit", "button" ) );
        $editWrapper->addContent( Xhtml::div( $field )->class_( "field_wrapper" ) );
        $editWrapper->addContent( Xhtml::div( "" )->attr( "data-icon", "trash" )->class_( "delete", "button" ) );

        $newWrapper = Xhtml::div()->class_( "setting_wrapper", "new" );
        $newWrapper->addContent( Xhtml::div( "" ) );
        $newWrapper->addContent( Xhtml::div( $field )->class_( "field_wrapper" ) );
        $newWrapper->addContent( Xhtml::div( "" )->attr( "data-icon", "plus" )->class_( "new", "button" ) );

        $wrapper->addContent( $editWrapper );
        $wrapper->addContent( $newWrapper );

        return $wrapper;
    }

    // ... /CREATE


    // ... DRAW


    /**
     * @see AbstractView::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        parent::draw( $root );

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_BUDGET_WRAPPER );

        // Toast overlay
        $this->drawToastOverlay( $wrapper );

        // New entry overlay
        //$this->drawEntryOverlay( $pageWrapper );
        $this->entryOverlay->draw( $wrapper );

        // Settings overlay
        $this->drawSettingsOverlay( $wrapper );

        // Dialog overlay
        $this->drawDialogOverlay( $wrapper );

        // Actionbar presenter
        $this->actionbarPresenter->draw( $wrapper );

        // Create page wrapper
        $pageWrapper = Xhtml::div()->id( self::$ID_BUDGET_PAGE_WRAPPER );

        // Budget page
        $this->budgetPage->draw( $pageWrapper );

        // Month page
        $this->monthPage->draw( $pageWrapper );

        $wrapper->addContent( $pageWrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    private function drawToastOverlay( AbstractXhtml $root )
    {

        $overlay = new OverlayPresenterView( $this );

        $overlay->setBackground( false );
        $overlay->setBottom( true );
        $overlay->setIndex( 1500 );
        $overlay->setFitWidth( true );
        $overlay->setId( "toast" );
        $overlay->addContent( Xhtml::div()->class_( "toast_message" ) );

        $overlay->draw( $root );

    }

    private function drawSettingsOverlay( AbstractXhtml $root )
    {

        $overlay = new OverlayPresenterView( $this );

        $overlay->setId( "settings" );
        $overlay->setTitle( "Settings" );
        $overlay->addButton(
                Xhtml::div()->attr( "data-icon", "check" )->class_( OverlayPresenterView::$OVERLAY_CANCEL ) );

        $content = Xhtml::div()->id( "settings_wrapper" );

        // TABS


        $tabs = new TabsPresenterView( $this );

        // ... BUDGETS


        $budgetsSettings = Xhtml::div()->id( "budgets_settings" );
        $budgetsSettingsEdit = Xhtml::div()->id( "budgets_edit" );

        $budgetsSettingsWrapper = Xhtml::div()->class_( "budgets_budget_wrapper" );
        $budgetsSettingsEditBudget = Xhtml::div()->class_( "budgets_budget_row", "edit", "template" );
        $budgetsSettingsEditBudget->addContent(
                Xhtml::div( Xhtml::span( Xhtml::img( Resource::image()->icon()->getEmpty() ) ) )->class_(
                        "budget_select" ) );
        $budgetsSettingsEditBudget->addContent(
                Xhtml::div()->attr( "data-icon", "edit" )->class_( "budget_edit", "button" ) );
        $budgetsSettingsEditBudget->addContent(
                Xhtml::div(
                        Xhtml::div(
                                Xhtml::input( "", "budget_title" )->placeholder( "Budget title" )->autocomplete( false ) )->class_(
                                "input_wrapper" ) ) );
        $budgetsSettingsEditBudget->addContent(
                Xhtml::div()->attr( "data-icon", "trash" )->class_( "budget_delete", "button" ) );

        $budgetsSettingsNewBudget = Xhtml::div()->class_( "budgets_budget_row", "new" );
        $budgetsSettingsNewBudget->addContent( Xhtml::div( Xhtml::$NBSP ) );
        $budgetsSettingsNewBudget->addContent( Xhtml::div( Xhtml::$NBSP ) );
        $budgetsSettingsNewBudget->addContent(
                Xhtml::div(
                        Xhtml::div( Xhtml::input( "", "budget_title" )->placeholder( "New Budget" )->autocomplete(
                                false ) )->class_( "input_wrapper" ) ) );
        $budgetsSettingsNewBudget->addContent( Xhtml::div()->attr( "data-icon", "plus" )->class_( "budget_add",
                "button" ) );

        $budgetsSettingsWrapper->addContent( $budgetsSettingsEditBudget );
        $budgetsSettingsWrapper->addContent( $budgetsSettingsNewBudget );
        $budgetsSettingsEdit->addContent( $budgetsSettingsWrapper );

        $budgetsSettings->addContent( $budgetsSettingsEdit );

        // ... USERS


        $budgetsSettingsUsers = Xhtml::div()->id( "budgets_users" );
        $budgetsSettingsUsers->addContent( Xhtml::h( 1, "Users" ) );

        $budgetsSettingsUsersTable = Xhtml::table()->class_( "budgets_user_wrapper" );
        $budgetsSettingsUsersShowRow = Xhtml::tr()->class_( "budgets_user_show_row", "template" );
        $budgetsSettingsUsersShowRow->addContent( Xhtml::td( "User email" )->class_( "budgets_user_email" ) );
        $budgetsSettingsUsersShowRow->addContent( Xhtml::td( "User name" )->class_( "budgets_user_name" ) );
        $budgetsSettingsUsersShowRow->addContent( Xhtml::td( "User logged in" )->class_( "budgets_user_loggedin" ) );
        $budgetsSettingsUsersShowRow->addContent(
                Xhtml::td( "" )->class_( "budgets_user_delete", "button" )->attr( "data-icon", "trash" ) );
        $budgetsSettingsUsersTable->addContent( $budgetsSettingsUsersShowRow );

        $budgetsSettingsUsersAddRow = Xhtml::tr()->class_( "budgets_user_add_row" );
        $budgetsSettingsUsersAddRow->addContent(
                Xhtml::td(
                        Xhtml::div( Xhtml::input( "", "budget_user_email" )->placeholder( "New User Email" ) )->class_(
                                "input_wrapper" ) )->colspan( 3 )->class_( "budgets_user_email" ) );
        $budgetsSettingsUsersAddRow->addContent(
                Xhtml::td( "" )->class_( "budgets_user_add", "button" )->attr( "data-icon", "plus" ) );
        $budgetsSettingsUsersTable->addContent( $budgetsSettingsUsersAddRow );

        $budgetsSettingsUsers->addContent( $budgetsSettingsUsersTable );
        $budgetsSettings->addContent( $budgetsSettingsUsers );

        // ... /USERS


        // ... /BUDGETS


        $cardsEditSettings = $this->createEditSettings( "cards_edit_settings",
                Xhtml::div(
                        Xhtml::div(
                                Xhtml::div(
                                        Xhtml::input( "", "card_title" )->placeholder( "Card" )->autocomplete( false ) )->class_(
                                        "input_wrapper" ) ) )->addContent(
                        Xhtml::div(
                                Xhtml::div(
                                        Xhtml::input( "", "card_number" )->placeholder( "Number" )->autocomplete(
                                                false ) )->class_( "input_wrapper" ) ) )->class_( Resource::css()->getTable() ) );
        $typesEditSettings = $this->createEditSettings( "types_edit_settings",
                Xhtml::div( Xhtml::input( "", "type_title" )->placeholder( "Type" )->autocomplete( false ) )->class_(
                        "input_wrapper" ) );

        $tabs->addTab( "budgets_settings",
                Xhtml::div( Xhtml::span()->attr( "data-icon", "pie" ) )->addContent( Xhtml::span( "Budgets" ) ),
                Xhtml::div( $budgetsSettings ) );
        $tabs->addTab( "cards_settings",
                Xhtml::div( Xhtml::span()->attr( "data-icon", "card" ) )->addContent( Xhtml::span( "Cards" ) ),
                Xhtml::div( $cardsEditSettings ) );
        $tabs->addTab( "types_settings",
                Xhtml::div( Xhtml::span()->attr( "data-icon", "shop" ) )->addContent( Xhtml::span( "Types" ) ),
                Xhtml::div( $typesEditSettings ) );

        $tabs->draw( $content );

        // /TABS


        $overlay->addContent( $content );

        $overlay->draw( $root );

    }

    private function drawDialogOverlay( AbstractXhtml $root )
    {

        $overlay = new OverlayPresenterView( $this );

        $overlay->setId( "dialog" );
        $overlay->setClass( "dialog_overlay" );
        $overlay->setFitWidth( true );
        $overlay->setBackground( false );
        $overlay->setMiddle( true );
        $overlay->setIndex( 2000 );

        $overlay->addContent( Xhtml::div()->class_( "dialog_content" ) );
        $overlay->addContent(
                Xhtml::div( Xhtml::div( "Cancel" )->class_( "dialog_cancel" ) )->addContent(
                        Xhtml::div( "OK" )->class_( "dialog_ok" ) )->class_( "dialog_buttons" ) );

        $overlay->draw( $root );

    }

    // ... /DRAW


    public function before()
    {
        parent::before();

        $this->budgetPage = new BudgetPageMainView( $this );
        $this->monthPage = new MonthPageMainView( $this );
        $this->entryOverlay = new EntryOverlayPresenterView( $this );
        $this->dialogOverlay = new OverlayPresenterView( $this );
    }

    // /FUNCTIONS


}

?>