<?php

class BudgetValidator extends Validator
{

    // VARIABLES



    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see Validator::getModel()
     * @return BudgetModel
     */
    public function getModel()
    {
        return parent::getModel();
    }

    protected function doTitle()
    {
        $this->validateRegex( "Budget title", self::$REGEX_TITLE,
                Core::utf8Decode( $this->getModel()->getTitle() ) );
    }

    // /FUNCTIONS


}

?>