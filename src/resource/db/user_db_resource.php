<?php

class UserDbResource
{

    // VARIABLES


    private $table = "user";

    private $fieldId = "user_id";
    private $fieldName = "user_name";
    private $fieldEmail = "user_email";
    private $fieldLoggedin = "user_loggedin";
    private $fieldUpdated = "user_updated";
    private $fieldRegistered = "user_registered";

    private $fieldAliasAuthUsers = "user_auth_users";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getTable()
    {
        return Core::constant( "DB_PREFIX" ) . $this->table;
    }

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getFieldLoggedin()
    {
        return $this->fieldLoggedin;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


    /**
     * @return the $fieldName
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return the $fieldEmail
     */
    public function getFieldEmail()
    {
        return $this->fieldEmail;
    }

    /**
     * @return the $fieldUpdated
     */
    public function getFieldUpdated()
    {
        return $this->fieldUpdated;
    }

    /**
     * @return the $fieldAliasAuthUsers
     */
    public function getFieldAliasAuthUsers()
    {
        return $this->fieldAliasAuthUsers;
    }

}

?>