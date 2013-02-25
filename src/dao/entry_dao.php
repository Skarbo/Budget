<?php

interface EntryDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return StandardListModel
     */
    public function getMonths( $budgetId );

    /**
     * @param int $month Timestamp
     * @return EntryListModel
     */
    public function getMonth( $budgetId, $month );

    /**
     * @return IteratorCore
     */
    public function getBudgets( $budgetId );

    // /FUNCTIONS


}

?>