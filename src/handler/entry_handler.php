<?php

class EntryHandler extends Handler
{

    // VARIABLES


    const TYPE_TITLE = "type_title";
    const CARD_TITLE = "card_title";
    const CARD_NUMBER = "card_number";

    /**
     * @var DaoContainer
     */
    private $daoContainer;
    /**
     * @var EntryValidator
     */
    private $entryValidator;
    /**
     * @var TypeValidator
     */
    private $typeValidator;
    /**
     * @var CardValidator
     */
    private $cardValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DaoContainer $daoContainer, EntryValidator $entryValidator, TypeValidator $typeValidator, CardValidator $cardValidator )
    {
        $this->daoContainer = $daoContainer;
        $this->entryValidator = $entryValidator;
        $this->typeValidator = $typeValidator;
        $this->cardValidator = $cardValidator;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param EntryModel $entry
     * @throws Exception
     */
    private function handleEntry( $budgetId, EntryModel $entry, $newTypeCard = array() )
    {

        // NEW TYPE


        if ( Core::arrayAt( $newTypeCard, self::TYPE_TITLE ) )
        {
            $type = TypeFactoryModel::createType( Core::arrayAt( $newTypeCard, self::TYPE_TITLE ) );
            $this->typeValidator->doValidate( $type );
            $type->setId( $this->daoContainer->getTypeDao()->add( $type, $budgetId ) );
            $entry->setType( $type->getId() );
        }

        // /NEW TYPE


        // NEW CARD


        if ( Core::arrayAt( $newTypeCard, self::CARD_TITLE ) )
        {
            $card = CardFactoryModel::createCard( Core::arrayAt( $newTypeCard, self::CARD_TITLE ),
                    Core::arrayAt( $newTypeCard, self::CARD_NUMBER ) );
            $this->cardValidator->doValidate( $card );
            $card->setId( $this->daoContainer->getCardDao()->add( $card, $budgetId ) );
            $entry->setCard( $card->getId() );
        }

        // /NEW CARD


        $type = $this->daoContainer->getTypeDao()->get( $entry->getType() );

        if ( !$type )
            throw new Exception( sprintf( "Type \"%s\" does not exist", $entry->getType() ) );

        $card = $this->daoContainer->getCardDao()->get( $entry->getCard() );

        if ( !$card )
            throw new Exception( sprintf( "Card \"%s\" does not exist", $entry->getCard() ) );

        $this->entryValidator->doValidate( $entry );

        return $entry;

    }

    /**
     * @param EntryModel $entry
     * @param array $newTypeCard Array( type_title, card_title, card_number ) Given if creating new type/card
     * @return EntryModel Added Entry
     * @throws Exception
     */
    public function handleNew( $budgetId, EntryModel $entry, $newTypeCard = array() )
    {

        $entry = $this->handleEntry( $budgetId, $entry, $newTypeCard );

        $entryId = $this->daoContainer->getEntryDao()->add( $entry, $budgetId );

        $entryAdded = $this->daoContainer->getEntryDao()->get( $entryId );

        return $entryAdded;

    }

    /**
     * @param EntryModel $entry
     * @param array $newTypeCard Array( type_title, card_title, card_number ) Given if creating new type/card
     * @param int $entryId
     * @return EntryModel
     */
    public function handleEdit( $budgetId, $entryId, EntryModel $entry, $newTypeCard = array() )
    {

        $entry = $this->handleEntry( $budgetId, $entry, $newTypeCard );

        $this->daoContainer->getEntryDao()->edit( $entryId, $entry, $budgetId );

        $entryEdited = $this->daoContainer->getEntryDao()->get( $entryId );

        return $entryEdited;

    }

    // /FUNCTIONS


}

?>