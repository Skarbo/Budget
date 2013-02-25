<?php

class MonthEntryFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $date
     * @param int $entries
     * @param itn $costSum
     * @return MonthEntryModel
     */
    public static function createEntryMonth( $budgetId, $date, $entries, $costSum, $costTotal )
    {
        $entryMonth = new MonthEntryModel();

        $entryMonth->setBudgetId(intval($budgetId));
        $entryMonth->setDate( Core::parseTimestamp( $date ) );
        $entryMonth->setId( intval( $entryMonth->getDate() ? date( "ym", $entryMonth->getDate() ) : 0 ) );
        $entryMonth->setEntries( intval( $entries ) );
        $entryMonth->setCostSum( round( intval( $costSum ), 2 ) );

        $totalExplode = explode( ",", $costTotal );
        $total = array ();
        foreach ( $totalExplode as $totalString )
        {
            list ( $day, $cost ) = explode( "|", $totalString );
            if ( key_exists( $day, $total ) )
                $total[ intval( $day ) ] += floatval( $cost );
            else
                $total[ intval( $day ) ] = floatval( $cost );
        }
        $entryMonth->setTotal( $total );

        return $entryMonth;
    }

    // /FUNCTIONS


}

?>