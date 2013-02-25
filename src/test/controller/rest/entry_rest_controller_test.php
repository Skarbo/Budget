<?php

class EntryRestControllerTest extends ControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "EntryRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function testShouldAddEntry()
    {
        // Create Entry
        $budget = $this->getDaoContainer()->addBudget();
        $type = $this->getDaoContainer()->addType();
        $card = $this->getDaoContainer()->addCard();
        $entry = $this->getDaoContainer()->createEntry( $budget->getId(), $type->getId(), $card->getId() );
        $entry->setCredit(1);
        $entry->setSingle(1);
        $entry->setComment("Comment");

        // Post Entry
        $url = self::getRestWebsite( sprintf( "%s/add", EntryRestController::$CONTROLLER_NAME ) );

        $data = $this->post( $url, self::createPostStandard( $entry ) );
        $dataArray = json_decode( $data, true );

        //         $this->showHeaders();
        //         $this->showRequest();
        //         $this->showSource();


        // Assert Entry
        if ( $this->assertResponse( AbstractController::STATUS_CREATED ) )
        {
            $entryRest = EntryFactoryModel::createEntryArray( self::getRestStandardSingle( $dataArray ) );

            if ( $this->assertFalse( empty( $entryRest ), "Entry REST should not be empty" ) )
            {
                $this->assertEqual( get_object_vars( $entry ), get_object_vars( $entryRest ) );
            }

        }

    }

    public function testShouldAddEntryTypeCard()
    {
        // Create Entry
        $budget = $this->getDaoContainer()->addBudget();
        $entry = $this->getDaoContainer()->createEntry( $budget->getId(), "", 0 );

        $cardTypeFields = array (
                EntryModel::CARD => EntryRestController::$POST_FIELD_NEW,
                EntryModel::TYPE => EntryRestController::$POST_FIELD_NEW,
                EntryRestController::$POST_FIELD_TYPE_TITLE => "Type New",
                EntryRestController::$POST_FIELD_CARD_TITLE => "Card New",
                EntryRestController::$POST_FIELD_CARD_NUMBER => "4321" );

        // Post Entry
        $url = self::getRestWebsite( sprintf( "%s/add", EntryRestController::$CONTROLLER_NAME ) );
        $data = $this->post( $url, self::createPostStandard( $entry, $cardTypeFields ) );
        $dataArray = json_decode( $data, true );

//         $this->showHeaders();
//         $this->showRequest();
//         $this->showSource();

        // Assert Entry
        if ( $this->assertResponse( AbstractController::STATUS_CREATED ) )
        {
            $entryRest = EntryFactoryModel::createEntryArray( self::getRestStandardSingle( $dataArray ) );

            $type = TypeModel::get_( $this->getDaoContainer()->getTypeDao()->get( $entryRest->getType() ) );
            if ( $this->assertFalse( is_null($type) ) )
            {
                $this->assertEqual( Core::arrayAt( $cardTypeFields, EntryRestController::$POST_FIELD_TYPE_TITLE ),
                        $type->getTitle() );
            }

            $card = CardModel::get_( $this->getDaoContainer()->getCardDao()->get( $entryRest->getCard() ) );
            if ( $this->assertFalse( is_null($card) ) )
            {
                $this->assertEqual( Core::arrayAt( $cardTypeFields, EntryRestController::$POST_FIELD_CARD_TITLE ),
                        $card->getTitle() );
                $this->assertEqual( Core::arrayAt( $cardTypeFields, EntryRestController::$POST_FIELD_CARD_NUMBER ),
                        $card->getNumber() );
            }
        }

    }

    // /FUNCTIONS


}

?>