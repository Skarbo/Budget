<?php

interface BudgetDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $userId
     * @return BudgetModel
     */
    public function getBudget( $budgetId, $userId );

    /**
     * @param int $userId
     * @return BudgetListModel
     */
    public function getBudgets( $userId );

    /**
     * @param int $budgetId
     * @param int $userId
     * @param string $userEmail
     * @return boolean True if added
     */
    public function addUser( $budgetId, $userId, $userEmail = null );

    /**
     * Merges user email with user id
     *
     * @return int Number of merged users
     */
    public function mergeUser();

    /**
     * @param int $budgetId
     * @param int $userId
     * @param string $userEmail
     * @return boolean True if edited
     */
    public function editUser( $budgetId, $userIdOrg, $userEmailOrg, $userId, $userEmail = null );

    /**
     * @param int $budgetId
     * @param int $userId
     * @param string $userEmail
     * @return int Number of removed users
     */
    public function removeUser( $budgetId, $userId, $userEmail = null );

    // /FUNCTIONS


}

?>