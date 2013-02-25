<?php

class EntryOverlayPresenterView extends OverlayPresenterView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... CREATE


    private function createSelect( $id, $name, $new )
    {
        $wrapper = Xhtml::div()->class_( "select_wrapper" )->id( $id );

        $select = function ( $name, $value, $for )
        {
            return Xhtml::div(
                    Xhtml::div( Xhtml::input( $value, $name )->type( InputXhtml::$TYPE_RADIO ) )->addContent(
                            Xhtml::img( Resource::image()->icon()->getEmpty() ) )->class_( "select_radio" ) )->addContent(
                    Xhtml::div( $for )->class_( "select_for" ) )->class_( "select_select" );
        };

        $wrapper->addContent( Xhtml::div( $select( $name, "value", "Select" ) )->class_( "select_template" ) );
        $wrapper->addContent( Xhtml::div()->class_( "select_container" ) );
        $wrapper->addContent( Xhtml::div( $select( $name, "_new", $new ) )->class_( "select_new" ) );

        return $wrapper;
    }

    // ... /CREATE


    public function draw( AbstractXhtml $root )
    {
        $this->setId( "entry" );
        $this->setTitle(
                Xhtml::div( Xhtml::span( "New Entry" )->class_( "new" ) )->addContent(
                        Xhtml::span( "Edit Entry" )->class_( "edit" ) ) );

        $this->addButton( Xhtml::div()->attr( "data-icon", "trash" )->class_( "entry_delete" ) );
        $this->addButton( Xhtml::div()->attr( "data-icon", "cross" )->class_( self::$OVERLAY_CANCEL ) );
        $this->addButton( Xhtml::div()->attr( "data-icon", "check" )->class_( self::$OVERLAY_OK ) );

        // Content


        //  ... Date
        $contentDate = Xhtml::div();
        $this->drawEntryDate( $contentDate );

        // ... Card
        $contentCard = Xhtml::div();
        $this->drawEntryCard( $contentCard );

        // ... Type
        $contentType = Xhtml::div();
        $this->drawEntryType( $contentType );

        // ... Cost
        $contentCost = Xhtml::div()->class_( Resource::css()->getCenter() );
        $this->drawEntryCost( $contentCost );

        // ... Comment
        $contentComment = Xhtml::div();
        $this->drawEntryComment( $contentComment );

        // ... Tabs
        $tabs = new TabsPresenterView( $this->getView() );
        $tabs->setId( "entry_new_tabs" );
        $tabs->addTab( "date", Xhtml::div( Xhtml::span()->attr( "data-icon", "calendar" ) )->addContent( "Date" ),
                $contentDate );
        $tabs->addTab( "card", Xhtml::div( Xhtml::span()->attr( "data-icon", "card" ) )->addContent( "Card" ),
                $contentCard );
        $tabs->addTab( "type", Xhtml::div( Xhtml::span()->attr( "data-icon", "shop" ) )->addContent( "Type" ),
                $contentType );
        $tabs->addTab( "cost", Xhtml::div( Xhtml::span()->attr( "data-icon", "dollar" ) )->addContent( "Cost" ),
                $contentCost );
        $tabs->addTab( "comment", Xhtml::div( Xhtml::span()->attr( "data-icon", "comment" ) )->addContent( "Comment" ),
                $contentComment );

        $entryForm = Xhtml::form()->id( "entry_form" );
        $tabs->draw( $entryForm );

        $this->addContent( $entryForm );

        // /Content


        parent::draw( $root );
    }

    private function drawEntryDate( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->class_( "calendar_wrapper" )->id( "entry_calendar" );

        $header = Xhtml::div()->class_( "calendar_header" );
        $headerMonthPrev = Xhtml::div( "" )->attr( "data-icon", "arrow-left" )->class_( "calendar_month_prev" );
        $headerMonthNext = Xhtml::div( "" )->attr( "data-icon", "arrow-right" )->class_( "calendar_month_next" );
        $headerMonth = Xhtml::div( Xhtml::div( "Month" )->class_( "month" ) )->addContent(
                Xhtml::div( "Year" )->class_( "year" ) )->class_( "calendar_monthyear" );
        $header->addContent( $headerMonthPrev );
        $header->addContent( $headerMonth );
        $header->addContent( $headerMonthNext );

        $calendar = Xhtml::div()->class_( "calendar" );
        $weekdaysWrapper = Xhtml::div()->class_( "calendar_weekdays_wrapper" );
        $weeksWrapper = Xhtml::div()->class_( "calendar_weeks_wrapper" );

        for ( $day = 1; $day <= 7; $day++ )
        {
            $weekdaysWrapper->addContent(
                    Xhtml::div( "" )->class_( "calendar_weekday" )->attr( "data-calendar-weekday", $day ) );
        }

        for ( $week = 1; $week <= 6; $week++ )
        {
            $weekWrapper = Xhtml::div()->class_( "calendar_week_wrapper" )->attr( "data-calendar-week", $week );
            for ( $day = 1; $day <= 7; $day++ )
            {
                $weekWrapper->addContent(
                        Xhtml::div( $day * $week )->class_( "calendar_day" )->attr( "data-calendar-day", $day * $week )->attr(
                                "data-calendar-weekday", $day )->attr( "data-calendar-week", $week ) );
            }
            $weeksWrapper->addContent( $weekWrapper );
        }

        $calendar->addContent( $weekdaysWrapper );
        $calendar->addContent( $weeksWrapper );

        $input = Xhtml::input( "", "date" )->autocomplete( false )->id( "entry_date" )->class_( "calendar_date" );

        $wrapper->addContent( $header );
        $wrapper->addContent( $calendar );
        $wrapper->addContent( $input );

        $root->addContent( $wrapper );

    }

    private function drawEntryCard( AbstractXhtml $root )
    {
        $root->addContent(
                $this->createSelect( "entry_card", "card",
                        Xhtml::div(
                                Xhtml::input( "", "card_title" )->type( InputXhtml::$TYPE_TEXT )->placeholder(
                                        "New card" ) )->addClass("input_wrapper") ) );
    }

    private function drawEntryType( AbstractXhtml $root )
    {
        $root->addContent(
                $this->createSelect( "entry_type", "type",
                        Xhtml::div(
                                Xhtml::input( "", "type_title" )->type( InputXhtml::$TYPE_TEXT )->placeholder(
                                        "New type" ) )->addClass("input_wrapper") ) );
    }

    private function drawEntryCost( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->class_( "cost_wrapper" )->id( "entry_cost" );

        $numberWrapper = Xhtml::div()->class_( "cost_number_wrapper" );
        $numberWrapper->addContent( Xhtml::div( Xhtml::$NBSP )->class_( "cost_number_temp" ) );
        $numberWrapper->addContent(
                Xhtml::input()->type( InputXhtml::$TYPE_TEXT )->placeholder( "0" )->class_( "cost_number_input" ) );
        $numberWrapper->addContent( Xhtml::input( "", "cost" )->class_( "cost_number_sum" ) );

        $calculatorWrapper = Xhtml::div()->class_( "cost_calculator_wrapper" );

        $calculatorRowWrapper = Xhtml::div()->class_( "cost_calculator_row_wrapper" );
        $calculatorRowWrapper->addContent( Xhtml::div( Xhtml::input("1", "credit")->type(InputXhtml::$TYPE_CHECKBOX)->class_("entry_credit") )->class_( "method" )->attr( "data-cost-method", "credit" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( Xhtml::input("1", "single")->type(InputXhtml::$TYPE_CHECKBOX)->class_("entry_single") )->class_( "method" )->attr( "data-cost-method", "single" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "method" )->attr( "data-cost-method", "back" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "method" )->attr( "data-cost-method", "clear" ) );
        $calculatorWrapper->addContent( $calculatorRowWrapper );

        $calculatorRowWrapper = Xhtml::div()->class_( "cost_calculator_row_wrapper" );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "7" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "8" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "9" ) );
        $calculatorRowWrapper->addContent(
                Xhtml::div( "" )->class_( "function" )->attr( "data-cost-function", "divide" ) );
        $calculatorWrapper->addContent( $calculatorRowWrapper );

        $calculatorRowWrapper = Xhtml::div()->class_( "cost_calculator_row_wrapper" );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "4" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "5" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "6" ) );
        $calculatorRowWrapper->addContent(
                Xhtml::div( "" )->class_( "function" )->attr( "data-cost-function", "multiply" ) );
        $calculatorWrapper->addContent( $calculatorRowWrapper );

        $calculatorRowWrapper = Xhtml::div()->class_( "cost_calculator_row_wrapper" );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "1" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "2" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "3" ) );
        $calculatorRowWrapper->addContent(
                Xhtml::div( "" )->class_( "function" )->attr( "data-cost-function", "substract" ) );
        $calculatorWrapper->addContent( $calculatorRowWrapper );

        $calculatorRowWrapper = Xhtml::div()->class_( "cost_calculator_row_wrapper" );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "period" ) );
        $calculatorRowWrapper->addContent( Xhtml::div( "" )->class_( "number" )->attr( "data-cost-number", "0" ) );
        $calculatorRowWrapper->addContent(
                Xhtml::div( "" )->class_( "function" )->attr( "data-cost-function", "equal" ) );
        $calculatorRowWrapper->addContent(
                Xhtml::div( "" )->class_( "function" )->attr( "data-cost-function", "addition" ) );
        $calculatorWrapper->addContent( $calculatorRowWrapper );

        $wrapper->addContent( $numberWrapper );
        $wrapper->addContent( $calculatorWrapper );

        $root->addContent( $wrapper );

    }

    private function drawEntryComment( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->class_( "comment_wrapper" )->id( "entry_comment" );

        $wrapper->addContent( Xhtml::textarea()->name( "comment" )->spellcheck( false )->placeholder(
                "Comment" ) );
        $wrapper->addContent(
                Xhtml::div( Xhtml::div( "Save Entry" )->attr("data-icon", "check")->class_( "entry_save_button" ) )->class_(
                        Resource::css()->getRight() ) );

        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

?>