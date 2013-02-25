<?php

class OverviewMonthPresenterView extends AbstractPresenterView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function draw( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->class_( "overview_wrapper" );

        $table = Xhtml::table()->class_( "overview_table" );

        $cardBody = Xhtml::tbody()->class_( "card_wrapper", "template" );
        $cardRow = Xhtml::tr()->class_( "card_row" );
        $typeRow = Xhtml::tr()->class_( "type_row" );
        $entryRow = Xhtml::tr()->class_( "entry_row" );
        //         $cardSumRow = Xhtml::tr()->class_( "card_sum_row" );


        $cardRow->addContent( Xhtml::td( "Card" )->colspan( 4 )->class_( "card" ) );

        $typeRow->addContent( Xhtml::td( "Type" )->class_( "type" ) );
        $typeRow->addContent( Xhtml::td( "Prday" )->class_( "prday" ) );
        $typeRow->addContent(
                Xhtml::td( Xhtml::span( Xhtml::span( "Entries" )->class_( "entries" ) )->class_( "entries_wrapper" ) )->class_(
                        "entries_count" ) );
        $typeRow->addContent( Xhtml::td( "Sum" )->class_( "sum" ) );

        $entryRow->addContent( Xhtml::td( "Date" )->class_( "date" ) );
        $entryRow->addContent( Xhtml::td( "Cost" )->class_( "cost" ) );
        $entryRow->addContent( Xhtml::td( "Single" )->class_( "single" ) );
        $entryRow->addContent( Xhtml::td( "Sum" )->class_( "cost_sum" ) );

        //         $cardSumRow->addContent( Xhtml::td( "Prday" )->colspan( 2 )->class_( "prday" ) );
        //         $cardSumRow->addContent( Xhtml::td( Xhtml::$NBSP ) );
        //         $cardSumRow->addContent( Xhtml::td( "Sum" )->class_( "sum" ) );


        $cardBody->addContent( $cardRow );
        $cardBody->addContent( $typeRow );
        $cardBody->addContent( $entryRow );
        //         $cardBody->addContent( $cardSumRow );
        $table->addContent( $cardBody );

        $wrapper->addContent( $table );
        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

?>