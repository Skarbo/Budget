<?php

class BudgetEntryFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return BudgetEntryModel
     */
    public static function createEntryBudget( $date, $entries, $costSum, $type, $card )
    {
        $entryBudget = new BudgetEntryModel();

        $entryBudget->setDate( Core::parseTimestamp( $date ) );
        $entryBudget->setEntries( intval( $entries ) );
        $entryBudget->setCostSum( round( doubleval( $costSum ), 2 ) );
        $entryBudget->setType( $type );
        $entryBudget->setCard( intval( $card ) );

        $entryBudget->doPrDay();

        return $entryBudget;
    }

    // /FUNCTIONS


}

?>