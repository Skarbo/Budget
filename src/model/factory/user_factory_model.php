<?php

class UserFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return UserModel
     */
    public static function createUser( $name, $email )
    {

        // Initiate model
        $user = new UserModel();

        $user->setName( Core::utf8Encode( $name ) );
        $user->setEmail( Core::utf8Encode( $email ) );

        // Return model
        return $user;

    }

    // /FUNCTIONS


}

?>