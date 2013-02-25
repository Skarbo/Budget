<?php

class TypeFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return TypeModel
     */
    public static function createType( $title )
    {

        // Initiate model
        $type = new TypeModel();

        $type->setTitle( Core::utf8Encode( Core::trimWhitespace( $title ) ) );

        // Return model
        return $type;

    }

    /**
     * @param array $typeArray
     * @return TypeModel
     */
    public static function createTypeArray( array $typeArray )
    {
        return self::createType( Core::arrayAt( $typeArray, TypeModel::TITLE ) );
    }

    // /FUNCTIONS


}

?>