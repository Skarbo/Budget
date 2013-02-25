<?php

class BudgetUrlResource extends ClassCore
{

    // VARIABLES


    private static $PAGE_BUDGET = "budget";
    private static $PAGE_ENTRY = "entry";
    private static $PAGE_ENTRIES = "entries";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getBudget( $mode = null, $url = "" )
    {
        return UrlResource::getController( BudgetMainController::$CONTROLLER_NAME, $mode, $url );
    }

    // /FUNCTIONS


}

?>