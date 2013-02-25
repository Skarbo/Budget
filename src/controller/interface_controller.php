<?php

interface InterfaceController
{

    /**
     * @return DaoContainer
     */
    public function getDaoContainer();

    /**
     * @return LoginHandler
     */
    public function getLoginHandler();

    /**
     * @return True if user must be logged in
     */
    public function isLoginForce();

    /**
     * @return UserModel
     */
    public function getUser();

}

?>