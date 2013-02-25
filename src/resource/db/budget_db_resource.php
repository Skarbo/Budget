<?php

class BudgetDbResource
{

    // VARIABLES


    private $table = "budget";
    private $tableUser = "budget_user";

    private $fieldId = "budget_id";
    private $fieldTitle = "budget_title";
    private $fieldUpdated = "budget_updated";
    private $fieldRegistered = "budget_registered";

    private $fieldAliasUserBudgetId = "budget_id";
    private $fieldAliasUserUserId = "user_id";
    private $fieldAliasUserEmail = "budget_user_email";
    private $fieldAliasUserUsers = "budget_users";

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

    public function getFieldTitle()
    {
        return $this->fieldTitle;
    }

    public function getFieldUpdated()
    {
        return $this->fieldUpdated;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


    /**
     * @return the $tableUser
     */
    public function getTableUser()
    {
        return Core::constant( "DB_PREFIX" ) . $this->tableUser;
    }

    /**
     * @return the $fieldAliasUserBudgetId
     */
    public function getFieldAliasUserBudgetId()
    {
        return $this->fieldAliasUserBudgetId;
    }

    /**
     * @return the $fieldAliasUserUserId
     */
    public function getFieldAliasUserUserId()
    {
        return $this->fieldAliasUserUserId;
    }

    /**
     * @return the $fieldAliasUserEmail
     */
    public function getFieldAliasUserEmail()
    {
        return $this->fieldAliasUserEmail;
    }

    /**
     * @return the $fieldAliasUserUsers
     */
    public function getFieldAliasUserUsers()
    {
        return $this->fieldAliasUserUsers;
    }

}

?>