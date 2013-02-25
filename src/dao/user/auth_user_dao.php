<?php

interface AuthUserDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param string $authId Auth id
     * @param string $type Auth type
     * @return AuthUserModel
     */
    public function getUser( $authId, $type );

    public function setLoggedin( $userId, $type );

    // /FUNCTIONS


}

?>