<?php

class EntryValidator extends Validator
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return EntryModel
     */
    function getModel()
    {
        return parent::getModel();
    }

    // ... /GET


    protected function doCost()
    {
        if ( !is_numeric( $this->getModel()->getCost() ) )
        {
            throw new ValidatorException( "Entry cost is not numeric" );
        }
    }

    protected function doDate()
    {
        if ( !Core::parseTimestamp( $this->getModel()->getDate() ) )
        {
            throw new ValidatorException( "Entry date is not a valid date" );
        }
    }

    // /FUNCTIONS


}

?>