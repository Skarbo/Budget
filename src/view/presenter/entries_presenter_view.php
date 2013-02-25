<?php

class EntriesPresenterView extends AbstractPresenterView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function draw( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->class_( "entries_wrapper" );

        $table = Xhtml::table()->class_( "entries" );

        // Month


        $entriesMonth = Xhtml::tbody()->attr( "data-month", "0" )->class_( "month", "template" );
        $entriesMonthRow = Xhtml::tr();

        // ... Month year
        $entriesMonthRow->addContent(
                Xhtml::td( Xhtml::div( "00" )->class_( "month" ) )->addContent( Xhtml::div( "00" )->class_( "year" ) )->class_(
                        "monthyear" ) );
        // ... Month
        $entriesMonthRow->addContent(
                Xhtml::td(
                        Xhtml::div( Xhtml::div( "Month" )->class_( "month" ) )->addContent(
                                Xhtml::div(
                                        Xhtml::span( Xhtml::span( "00" )->class_( "entries" ) )->class_(
                                                "entries_wrapper" ) )->class_( "right" ) )->class_( "table" ) )->class_(
                        "month" ) );
        // ... Cost sum
        $entriesMonthRow->addContent( Xhtml::td( "000.00" )->class_( "cost_sum" ) );

        $entriesMonth->addContent( $entriesMonthRow );
        $table->addContent( $entriesMonth );

        // /Month


        $monthEntries = Xhtml::tbody()->attr( "data-month", "0" )->class_( "month_entries", "template" );

        // Entry


        $entriesEntry = Xhtml::tr()->class_( "entry" );

        // ... Date
        $entriesEntry->addContent( Xhtml::td( "00" )->class_( "date" ) );

        // ... Type/Card/Comment
        $entriesEntryTable = Xhtml::table();
        $entriesEntryTable->addContent(
                Xhtml::tr( Xhtml::td( "Type" )->class_( "type" ) )->addContent( Xhtml::td( "Card" )->class_( "card" ) ) );
        $entriesEntryTable->addContent( Xhtml::tr( Xhtml::td( "Comment" )->colspan( 2 )->class_( "comment" ) ) );
        $entriesEntry->addContent( Xhtml::td( $entriesEntryTable )->class_( "type_card_comment" ) );

        // ... Cost
        $entriesEntry->addContent( Xhtml::td( "000.00" )->class_( "cost" ) );
        $monthEntries->addContent( $entriesEntry );

        // /Entry


        // ... No entry
        $monthEntries->addContent( Xhtml::tr( Xhtml::td( "No entries" )->colspan( 3 ) )->class_(
                "entry_none" ) );

        // ... Loading entries
        $monthEntries->addContent(
                Xhtml::tr(
                        Xhtml::td(
                                Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading entries" )->title(
                                        "Loading entries" ) )->colspan( 3 ) )->class_( "entry_loading" ) );

        $table->addContent( $monthEntries );
        $wrapper->addContent( $table );
        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

?>