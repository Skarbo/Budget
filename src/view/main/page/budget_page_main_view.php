<?php

class BudgetPageMainView extends AbstractPageMainView
{

    // VARIABLES


    public static $WRAPPER_ID = "budget_page_wrapper";

    /**
     * @var EntriesPresenterView
     */
    private $entriesPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( AbstractMainView $view )
    {
        parent::__construct( $view );

        $this->entriesPresenter = new EntriesPresenterView( $view );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function draw( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->id( self::$WRAPPER_ID )->class_("page", "hide")->attr("data-page", "budget");

        // Entries presenter
        $this->entriesPresenter->draw( $wrapper );

        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

?>