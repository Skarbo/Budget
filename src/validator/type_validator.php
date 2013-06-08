<?php

class TypeValidator extends Validator
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see Validator::getModel()
     * @return TypeModel
     */
    public function getModel()
    {
        return parent::getModel();
    }

    protected function doTitle()
    {
        $this->validateRegex( "Type title", self::$REGEX_TITLE, Core::utf8Decode( $this->getModel()->getTitle() ) );
        $this->validateLength( "Type title", Core::utf8Decode( $this->getModel()->getTitle() ), 2 );
    }

    // /FUNCTIONS


}

?>