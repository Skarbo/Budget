<?php

class EntryFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return EntryModel
     */
    public static function createEntry( $cost, $type, $card, $date, $comment = "", $single = 0, $credit = 0 )
    {

        // Initiate model
        $entry = new EntryModel();

        $entry->setCost( round( doubleval( $cost ), 2 ) );
        $entry->setComment( Core::utf8Encode( Core::trimWhitespace( str_replace( "\n", " ", $comment ) ) ) );
        $entry->setCredit( intval( $credit ) );
        $entry->setDate( Core::parseTimestamp( $date ) );
        $entry->setMonthId( intval( $entry->getDate() ? date( "ym", $entry->getDate() ) : 0 ) );
        $entry->setSingle( intval( $single ) );
        $entry->setType( intval( $type ) );
        $entry->setCard( intval( $card ) );

        // Return model
        return $entry;

    }

    /**
     * @param array $entryArray
     * @return EntryModel
     */
    public static function createEntryArray( array $entryArray )
    {
        return self::createEntry( Core::arrayAt( $entryArray, EntryModel::COST ),
                Core::arrayAt( $entryArray, EntryModel::TYPE ), Core::arrayAt( $entryArray, EntryModel::CARD ),
                Core::arrayAt( $entryArray, EntryModel::DATE ), Core::arrayAt( $entryArray, EntryModel::COMMENT, "" ),
                Core::arrayAt( $entryArray, EntryModel::SINGLE, 0 ), Core::arrayAt( $entryArray, EntryModel::CREDIT, 0 ) );
    }

    // /FUNCTIONS


}

?>