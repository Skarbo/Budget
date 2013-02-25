<?php

class BudgetFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return BudgetModel
     */
    public static function createBudget( $title )
    {

        // Initiate model
        $budget = new BudgetModel();

        $budget->setTitle( Core::utf8Encode( $title ) );

        // Return model
        return $budget;

    }

    /**
     * @param array $array
     * @return BudgetModel
     */
    public static function createBudgetArray( array $array )
    {
        return self::createBudget( Core::arrayAt( $array, BudgetModel::TITLE ) );
    }

    // /FUNCTIONS


}

?>