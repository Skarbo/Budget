<?php

class CardValidator extends Validator
{

    // VARIABLES


    private static $REGEX_CARD_NUMBER = '/[^\/\d\s\,]/i';

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see Validator::getModel()
     * @return CardModel
     */
    public function getModel()
    {
        return parent::getModel();
    }

    protected function doTitle()
    {
        $this->validateRegex( "Card title", self::$REGEX_TITLE, Core::utf8Decode( $this->getModel()->getTitle() ) );
        $this->validateLength( "Type title", Core::utf8Decode( $this->getModel()->getTitle() ), 2 );
    }

    protected function doNumber()
    {
        $this->validateRegex( "Card number", self::$REGEX_CARD_NUMBER, $this->getModel()->getNumber() );
    }

    // /FUNCTIONS


}

?>