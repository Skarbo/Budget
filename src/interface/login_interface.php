<?php

interface LoginInterface
{

    /**
     * @return string Google auth URL
     */
    public function getGoogleAuthUrl();

    /**
     * @return string Facebook auth URL
     */
    public function getFacebookAuthUrl();

    /**
     * @return UserModel Null if not logged in
     */
    public function getUser();

    /**
     * @returns boolean True if logged in
     */
    public function isLoggedIn();

}

?>