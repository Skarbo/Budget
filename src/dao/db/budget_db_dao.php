<?php

class BudgetDbDao extends StandardDbDao implements BudgetDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see StandardDbDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->budget()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->budget()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->budget()->getFieldId();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();
        $model = BudgetModel::get_( $model );

        $fields[ Resource::db()->budget()->getFieldTitle() ] = ":title";
        $binds[ "title" ] = Core::utf8Decode( $model->getTitle() );

        if ( !$isInsert )
        {
            $fields[ Resource::db()->budget()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    private function getInsertUpdateUserFieldsBinds( $budgetId, $userId, $userEmail )
    {
        $fields = array ();
        $binds = array ();

        $fields[ Resource::db()->budget()->getFieldAliasUserBudgetId() ] = ":budgetId";
        $binds[ "budgetId" ] = $budgetId;

        if ( $userId )
        {
            $fields[ Resource::db()->budget()->getFieldAliasUserUserId() ] = ":userId";
            $binds[ "userId" ] = $userId;
        }
        else
        {
            $fields[ Resource::db()->budget()->getFieldAliasUserUserId() ] = SB::$NULL;
        }

        if ( $userEmail )
        {
            $fields[ Resource::db()->budget()->getFieldAliasUserEmail() ] = ":userEmail";
            $binds[ "userEmail" ] = $userEmail;
        }
        else
        {
            $fields[ Resource::db()->budget()->getFieldAliasUserEmail() ] = SB::$NULL;
        }

        return array ( $fields, $binds );
    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new BudgetListModel();
    }

    /**
     * @see StandardDbDao::getSelectQuery()
     */
    protected function getSelectQuery()
    {
        $selectQuery = parent::getSelectQuery();

        /*
         * SELECT
GROUP_CONCAT(IF(ISNULL(budget_budget_user.user_id),
budget_budget_user.budget_user_email, CONCAT_WS(",",budget_user.user_email, budget_user.user_name)) SEPARATOR "|")
 FROM budget_budget_user
LEFT JOIN budget_user ON budget_user.user_id = budget_budget_user.user_id
GROUP BY budget_budget_user.budget_id
         */
        $selectAuthBuilder = new SelectSqlbuilderDbCore();
        $selectAuthBuilder->setExpression(
                SB::groupConcat(
                        Core::cc( " ",
                                SB::if_(
                                        SB::isnull(
                                                SB::pun( Resource::db()->budget()->getTableUser(),
                                                        Resource::db()->budget()->getFieldAliasUserUserId() ) ),
                                        SB::pun( Resource::db()->budget()->getTableUser(),
                                                Resource::db()->budget()->getFieldAliasUserEmail() ),
                                        SB::concat( ",",
                                                SB::pun( Resource::db()->user()->getTable(),
                                                        Resource::db()->user()->getFieldEmail() ),
                                                SB::pun( Resource::db()->user()->getTable(),
                                                        Resource::db()->user()->getFieldId() ),
                                                SB::pun( Resource::db()->user()->getTable(),
                                                        Resource::db()->user()->getFieldName() ),
                                                SB::unixTimestamp(
                                                        SB::pun( Resource::db()->user()->getTable(),
                                                                Resource::db()->user()->getFieldLoggedin() ) ) ) ),
                                SB::$SEPARATOR, SB::quote( "|" ) ) ) );
        $selectAuthBuilder->setFrom( Resource::db()->budget()->getTableUser() );
        $selectAuthBuilder->addJoin(
                SB::join( Resource::db()->user()->getTable(),
                        SB::equ( SB::pun( Resource::db()->user()->getTable(), Resource::db()->user()->getFieldId() ),
                                SB::pun( Resource::db()->budget()->getTableUser(),
                                        Resource::db()->budget()->getFieldAliasUserUserId() ) ) ), SB::$LEFT );
        $selectAuthBuilder->setWhere(
                SB::equ(
                        SB::pun( Resource::db()->budget()->getTableUser(),
                                Resource::db()->budget()->getFieldAliasUserBudgetId() ),
                        SB::pun( Resource::db()->budget()->getTable(), Resource::db()->budget()->getFieldId() ) ) );
        $selectAuthBuilder->setGroupBy(
                SB::pun( Resource::db()->budget()->getTableUser(),
                        Resource::db()->budget()->getFieldAliasUserBudgetId() ) );

        $selectQuery->getQuery()->addExpression(
                SB::as_( SB::par( $selectAuthBuilder->build() ), Resource::db()->budget()->getFieldAliasUserUsers() ) );

        return $selectQuery;
    }

    /**
     * @param int $userId
     * @return SelectQueryDbCore
     */
    private function getBudgetQuery( $userId )
    {
        $selectQuery = $this->getSelectQuery();

        $selectAuthBuilder = new SelectSqlbuilderDbCore( Resource::db()->budget()->getFieldAliasUserBudgetId(),
                Resource::db()->budget()->getTableUser(),
                SB::equ( Resource::db()->budget()->getFieldAliasUserUserId(), ":userId" ) );
        $selectQuery->getQuery()->addWhere(
                SB::in( Resource::db()->budget()->getFieldId(), SB::par( $selectAuthBuilder->build() ) ) );
        $selectQuery->addBind( array ( "userId" => $userId ) );

        return $selectQuery;
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {
        if ( empty( $modelArray ) )
            return null;

        $model = BudgetFactoryModel::createBudget(
                Core::arrayAt( $modelArray, Resource::db()->budget()->getFieldTitle() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->budget()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->budget()->getFieldRegistered() ) ) );

        $budgetUsers = explode( "|", Core::arrayAt( $modelArray, Resource::db()->budget()->getFieldAliasUserUsers() ) );
        foreach ( $budgetUsers as $budgetUser )
        {
            $model->addUser( explode(",", $budgetUser ) );
        }

        return $model;

    }

    // ... /CREATE


    /**
     * @see BudgetDao::getBudget()
     */
    public function getBudget( $budgetId, $userId )
    {
        $selectQuery = $this->getBudgetQuery( $userId );

        $selectQuery->getQuery()->addWhere( SB::equ( Resource::db()->budget()->getFieldId(), ":budgetId" ) );
        $selectQuery->addBind( array ( "budgetId" => $budgetId ) );

        $result = $this->getDbApi()->query( $selectQuery );
        return $this->createModel( $result->getRow( 0 ) );
    }

    /**
     * @see BudgetDao::getBudgets()
     */
    public function getBudgets( $userId )
    {
        $selectQuery = $this->getBudgetQuery( $userId );

        $result = $this->getDbApi()->query( $selectQuery );

        return $this->createList( $result->getRows() );
    }

    /**
     * @see BudgetDao::addUser()
     */
    public function addUser( $budgetId, $userId, $userEmail = null )
    {
        $insertQuery = new InsertQueryDbCore();

        list ( $fields, $binds ) = $this->getInsertUpdateUserFieldsBinds( $budgetId, $userId, $userEmail );

        $insertBuilder = new InsertSqlbuilderDbCore( Resource::db()->budget()->getTableUser() );
        $insertBuilder->setSetValues( $fields );

        $insertQuery->setQuery( $insertBuilder );
        $insertQuery->setBinds( $binds );

        $result = $this->getDbApi()->query( $insertQuery );

        return $result->isExecute();
    }

    /**
     * @see BudgetDao::mergeUser()
     */
    public function mergeUser()
    {

        $updateQuery = new UpdateQueryDbCore();

        $selectUserBuilder = new SelectSqlbuilderDbCore(
                SB::ifnull( SB::pun( Resource::db()->user()->getTable(), Resource::db()->user()->getFieldId() ), null,
                        SB::pun( Resource::db()->budget()->getTableUser(),
                                Resource::db()->budget()->getFieldAliasUserUserId() ) ), Resource::db()->user()->getTable(),
                SB::like( SB::pun( Resource::db()->user()->getTable(), Resource::db()->user()->getFieldEmail() ),
                        SB::pun( Resource::db()->budget()->getTableUser(),
                                Resource::db()->budget()->getFieldAliasUserEmail() ) ), null, array (), 1 );

        $updateBuilder = new UpdateSqlbuilderDbCore( Resource::db()->budget()->getTableUser() );
        $updateBuilder->setSet(
                array ( Resource::db()->budget()->getFieldAliasUserUserId() => SB::par( $selectUserBuilder->build() ) ) );
        $updateBuilder->addWhere(
                SB::isnull(
                        SB::pun( Resource::db()->budget()->getTableUser(),
                                Resource::db()->budget()->getFieldAliasUserUserId() ) ) );

        $updateQuery->setQuery( $updateBuilder );

        $result = $this->getDbApi()->query( $updateQuery );

        return $result->getAffectedRows();

    }

    /**
     * @see BudgetDao::editUser()
     */
    public function editUser( $budgetId, $userIdOrg, $userEmailOrg, $userId, $userEmail = null )
    {
        $updateQuery = new UpdateQueryDbCore();

        list ( $fields, $binds ) = $this->getInsertUpdateUserFieldsBinds( $budgetId, $userId, $userEmail );

        $updateBuilder = new UpdateSqlbuilderDbCore( Resource::db()->budget()->getTableUser() );
        $updateBuilder->setSet( $fields );
        $updateBuilder->setWhere( SB::equ( Resource::db()->budget()->getFieldAliasUserBudgetId(), ":budgetIdOrg" ) );
        $updateBuilder->addWhere(
                $userIdOrg ? SB::equ( Resource::db()->budget()->getFieldAliasUserUserId(), ":userIdOrg" ) : SB::isnull(
                        Resource::db()->budget()->getFieldAliasUserUserId() ) );
        $updateBuilder->addWhere(
                $userEmailOrg ? SB::equ( Resource::db()->budget()->getFieldAliasUserEmail(), ":userEmailOrg" ) : SB::isnull(
                        Resource::db()->budget()->getFieldAliasUserEmail() ) );

        $updateQuery->setQuery( $updateBuilder );
        $updateQuery->setBinds( $binds );
        $updateQuery->addBind( array ( "budgetIdOrg" => $budgetId ) );
        if ( $userIdOrg )
            $updateQuery->addBind( array ( "userIdOrg" => $userIdOrg ) );
        if ( $userEmailOrg )
            $updateQuery->addBind( array ( "userEmailOrg" => $userEmailOrg ) );

        $result = $this->getDbApi()->query( $updateQuery );

        return $result->getAffectedRows();
    }

    /**
     * @see BudgetDao::removeUser()
     */
    public function removeUser( $budgetId, $userId, $userEmail = null )
    {
        $deleteQuery = new DeleteQueryDbCore();

        $deleteBuilder = new DeleteSqlbuilderDbCore( Resource::db()->budget()->getTableUser() );
        $deleteBuilder->setWhere( SB::equ( Resource::db()->budget()->getFieldAliasUserBudgetId(), ":budgetId" ) );
        $deleteBuilder->addWhere(
                $userId ? SB::equ( Resource::db()->budget()->getFieldAliasUserUserId(), ":userId" ) : SB::isnull(
                        Resource::db()->budget()->getFieldAliasUserUserId() ) );
        $deleteBuilder->addWhere(
                $userEmail ? SB::equ( Resource::db()->budget()->getFieldAliasUserEmail(), ":email" ) : SB::isnull(
                        Resource::db()->budget()->getFieldAliasUserEmail() ) );

        $deleteQuery->setQuery( $deleteBuilder );

        $deleteQuery->addBind( array ( "budgetId" => $budgetId ) );
        if ( $userEmail )
            $deleteQuery->addBind( array ( "email" => $userEmail ) );
        if ( $userId )
            $deleteQuery->addBind( array ( "userId" => $userId ) );

        $result = $this->getDbApi()->query( $deleteQuery );

        return $result->getAffectedRows();
    }

    // /FUNCTIONS


}

?>