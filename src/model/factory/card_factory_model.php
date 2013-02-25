<?php

class CardFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return CardModel
     */
    public static function createCard( $title, $number, $joint = 0 )
    {

        // Initiate model
        $card = new CardModel();

        $card->setTitle( Core::utf8Encode( Core::trimWhitespace( $title ) ) );
        $card->setNumber( Core::trimWhitespace( $number ) );
        $card->setJoint( intval( $joint ) );

        // Return model
        return $card;

    }

    /**
     * @param array $cardArray
     * @return CardModel
     */
    public static function createCardArray( array $cardArray )
    {
        return self::createCard( Core::arrayAt( $cardArray, CardModel::TITLE ),
                Core::arrayAt( $cardArray, CardModel::NUMBER ), Core::arrayAt( $cardArray, CardModel::JOINT ) );
    }

    // /FUNCTIONS


}

?>