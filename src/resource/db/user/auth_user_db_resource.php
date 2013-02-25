<?php

class AuthUserDbResource
{

    // VARIABLES


    private $table = "user_auth";

    private $fieldUserId = "user_id";
    private $fieldUserAuthId = "user_auth_id";
    private $fieldUserAuthType = "user_auth_type";
    private $fieldUserAuthName = "user_auth_name";
    private $fieldUserAuthEmail = "user_auth_email";
    private $fieldUserAuthLoggedin = "user_auth_loggedin";
    private $fieldUserAuthRegistered = "user_auth_registered";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getTable()
    {
        return Core::constant( "DB_PREFIX" ) . $this->table;
    }

    public function getFieldUserId()
    {
        return $this->fieldUserId;
    }

    public function getFieldUserAuthType()
    {
        return $this->fieldUserAuthType;
    }

    public function getFieldUserAuthName()
    {
        return $this->fieldUserAuthName;
    }

    public function getFieldUserAuthEmail()
    {
        return $this->fieldUserAuthEmail;
    }

    public function getFieldUserAuthLoggedin()
    {
        return $this->fieldUserAuthLoggedin;
    }

    public function getFieldUserAuthRegistered()
    {
        return $this->fieldUserAuthRegistered;
    }

    // /FUNCTIONS


    /**
     * @return the $fieldUserAuthId
     */
    public function getFieldUserAuthId()
    {
        return $this->fieldUserAuthId;
    }

}

?>