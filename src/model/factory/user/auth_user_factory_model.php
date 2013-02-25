<?php

class AuthUserFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return AuthUserModel
     */
    public static function createAuthUser( $userAuthId, $userId, $userAuthType, $userAuthLastLoggedin = null )
    {

        // Initiate model
        $authUser = new AuthUserModel();

        $authUser->setId( $userAuthId );
        $authUser->setUserId( intval( $userId ) );
        $authUser->setUserAuthType( $userAuthType );
        $authUser->setUserAuthLoggedin( Core::parseTimestamp( $userAuthLastLoggedin ) );

        // Return model
        return $authUser;

    }

    // /FUNCTIONS


}

?>