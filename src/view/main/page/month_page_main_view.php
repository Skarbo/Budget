<?php

class MonthPageMainView extends AbstractPageMainView
{

    // VARIABLES


    public static $WRAPPER_ID = "month_page_wrapper";

    /**
     * @var EntriesPresenterView
     */
    private $entriesPresenter;
    /**
     * @var OverviewMonthPresenterView
     */
    private $overviewPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( AbstractMainView $view )
    {
        parent::__construct( $view );

        $this->entriesPresenter = new EntriesPresenterView( $view );
        $this->overviewPresenter = new OverviewMonthPresenterView( $view );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractPageMainView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->id( self::$WRAPPER_ID )->class_( "page", "hide" )->attr( "data-page", "month" );

        // Entries
        $entriesWrapper = Xhtml::div()->id( "entries_month_wrapper" );
        $this->entriesPresenter->draw( $entriesWrapper );

        // Overview
        $overviewWrapper = Xhtml::div()->id( "overview_month_wrapper" );
        $this->overviewPresenter->draw( $overviewWrapper );

        // Chart
        $chartWrapper = Xhtml::div(
                Xhtml::div( Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading Chart" ) )->class_(
                        Resource::css()->getCenter() ) )->id( "chart_month_wrapper" );

        $tabs = new TabsPresenterView( $this->getView() );
        $tabs->addTab( "entries_month", Xhtml::div( "Entries" ), $entriesWrapper );
        $tabs->addTab( "overview_month", Xhtml::div( "Overview" ), $overviewWrapper );
        $tabs->addTab( "chart_month", Xhtml::div( "Chart" ), $chartWrapper );
        $tabs->draw( $wrapper );

        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

?>