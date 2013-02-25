<?php

class BudgetHandler extends Handler
{

    // VARIABLES


    /**
     * @var DaoContainer
     */
    private $daoContainer;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DaoContainer $daoContainer )
    {
        $this->daoContainer = $daoContainer;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


}

?>