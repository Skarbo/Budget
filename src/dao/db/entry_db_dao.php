<?php

class EntryDbDao extends StandardDbDao implements EntryDao
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
        return Resource::db()->entry()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->entry()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->entry()->getFieldBudgetId();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();
        $model = EntryModel::get_( $model );

        $fields[ Resource::db()->entry()->getFieldCost() ] = ":cost";
        $binds[ "cost" ] = $model->getCost();
        $fields[ Resource::db()->card()->getFieldBudgetId() ] = ":budgetId";
        $binds[ "budgetId" ] = $foreignId;
        $fields[ Resource::db()->entry()->getFieldComment() ] = ":comment";
        $binds[ "comment" ] = Core::utf8Decode( $model->getComment() );
        $fields[ Resource::db()->entry()->getFieldCredit() ] = ":debit";
        $binds[ "debit" ] = $model->getCredit();
        $fields[ Resource::db()->entry()->getFieldDate() ] = ":date";
        $binds[ "date" ] = date( self::$SQL_DATE_FORMAT_Ymd, $model->getDate() );
        $fields[ Resource::db()->entry()->getFieldSingle() ] = ":divide";
        $binds[ "divide" ] = $model->getSingle();
        $fields[ Resource::db()->entry()->getFieldType() ] = ":type";
        $binds[ "type" ] = $model->getType();
        $fields[ Resource::db()->entry()->getFieldCard() ] = ":card";
        $binds[ "card" ] = $model->getCard();

        if ( !$isInsert )
        {
            $fields[ Resource::db()->entry()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new EntryListModel();
    }

    /**
     * @see StandardDbDao::getSelectQuery()
     */
    protected function getSelectQuery()
    {
        $selectQuery = parent::getSelectQuery();

        $selectQuery->getQuery()->setOrderBy( array ( array ( Resource::db()->entry()->getFieldDate(), SB::$ASC ) ) );

        return $selectQuery;
    }

    private function getCostSumExpression( $table, $alias = null )
    {
        /*
        SUM(IF(budget_entry.entry_single,
                budget_entry.entry_cost / ((
                        SELECT COUNT(DISTINCT budget_card.card_id)
                        FROM budget_card
                        WHERE budget_card.card_joint = 0)),
                budget_entry.entry_cost
        )
                * IF(budget_entry.entry_credit,-1,1)
        ) AS entry_costs
        */
        $selectBuilderCardsExpression = new SelectSqlbuilderDbCore(
                SB::count( sprintf( "%s %s", SB::$DISTINCT, Resource::db()->card()->getFieldId() ) ),
                Resource::db()->card()->getTable(),
                SB::and_( SB::equ( Resource::db()->card()->getFieldJoint(), "0" ),
                        SB::equ(
                                SB::pun( Resource::db()->card()->getTable(),
                                        Resource::db()->card()->getFieldBudgetId() ), ":budgetId" ) ) );
        $expression = SB::sum(
                SB::multiply(
                        SB::if_( SB::pun( $table, Resource::db()->entry()->getFieldSingle() ),
                                SB::pun( $table, Resource::db()->entry()->getFieldCost() ),
                                SB::divide( SB::pun( $table, Resource::db()->entry()->getFieldCost() ),
                                        SB::par( $selectBuilderCardsExpression->build() ) ) ),
                        SB::if_( SB::pun( $table, Resource::db()->entry()->getFieldCredit() ), -1, 1 ) ) );
        if ( $alias )
            $expression = SB::as_( $expression, $alias );
        return $expression;
    }

    /**
     * @see EntryDao::getMonths()
     */
    public function getMonths( $budgetId )
    {

        $selectQuery = new SelectQueryDbCore( new SelectSqlbuilderDbCore() );

        /* SELECT SUM(be2.entry_cost) FROM budget_entry AS be2 WHERE be2.entry_date = be.entry_date */
        $selectTotalBuilder = new SelectSqlbuilderDbCore( SB::round( $this->getCostSumExpression( "be" ), 2 ),
                SB::tblAs( Resource::db()->entry()->getTable(), "be" ),
                SB::and_(
                        SB::equ( SB::pun( "be", Resource::db()->entry()->getFieldCost() ),
                                SB::pun( Resource::db()->entry()->getTable(), Resource::db()->entry()->getFieldCost() ) ),
                        SB::equ( SB::pun( "be", Resource::db()->entry()->getFieldBudgetId() ), ":budgetId" ) ) );

        /*
         SELECT budget_entry.entry_date, COUNT(budget_entry.entry_date) AS entry_entries, SUM(IF(budget_entry.entry_single,
                 budget_entry.entry_cost / ((
                         SELECT COUNT(DISTINCT budget_card.card_id)
                         FROM budget_card
                         WHERE budget_card.card_joint = 0)),
                 budget_entry.entry_cost
         )
                 * IF(budget_entry.entry_credit,-1,1)
         ) AS entry_costs
        FROM budget_entry
        GROUP BY MONTH(budget_entry.entry_date)
        */
        $selectQuery->getQuery()->setExpression( Resource::db()->entry()->getFieldDate() );
        $selectQuery->getQuery()->addExpression(
                SB::as_( SB::max( Resource::db()->entry()->getFieldRegistered() ),
                        Resource::db()->entry()->getFieldRegistered() ) );
        $selectQuery->getQuery()->addExpression(
                SB::as_( SB::max( Resource::db()->entry()->getFieldUpdated() ),
                        Resource::db()->entry()->getFieldUpdated() ) );
        $selectQuery->getQuery()->addExpression(
                SB::as_( SB::count( Resource::db()->entry()->getFieldDate() ),
                        Resource::db()->entry()->getFieldAliasEntries() ) );
        $selectQuery->getQuery()->addExpression(
                $this->getCostSumExpression( Resource::db()->entry()->getTable(),
                        Resource::db()->entry()->getFieldAliasCostSum() ) );
        $selectQuery->getQuery()->addExpression(
                $this->getCostSumExpression( Resource::db()->entry()->getTable(),
                        Resource::db()->entry()->getFieldBudgetId() ) );
        $selectQuery->getQuery()->addExpression(
                SB::as_(
                        SB::groupConcat(
                                Core::cc( " ",
                                        SB::concat( "|", SB::day( Resource::db()->entry()->getFieldDate() ),
                                                SB::par( $selectTotalBuilder->build() ) ), SB::$ORDER_BY,
                                        SB::day( Resource::db()->entry()->getFieldDate() ), SB::$SEPARATOR,
                                        SB::quote( "," ) ), Resource::db()->entry()->getFieldAliasCostTotal() ),
                        Resource::db()->entry()->getFieldAliasCostTotal() ) );
        $selectQuery->getQuery()->setFrom( Resource::db()->entry()->getTable() );
        $selectQuery->getQuery()->addWhere( SB::equ( Resource::db()->entry()->getFieldBudgetId(), ":budgetId" ) );
        $selectQuery->getQuery()->setGroupBy( SB::month( Resource::db()->entry()->getFieldDate() ),
                SB::year( Resource::db()->entry()->getFieldDate() ) );
        $selectQuery->getQuery()->setOrderBy( array ( array ( Resource::db()->entry()->getFieldDate(), SB::$DESC ) ) );

        $selectQuery->addBind( array ( "budgetId" => $budgetId ) );

        $result = $this->getDbApi()->query( $selectQuery );

        $entryMonths = new StandardListModel();
        foreach ( $result->getRows() as $row )
        {
            $entryMonth = MonthEntryFactoryModel::createEntryMonth(
                    Core::arrayAt( $row, Resource::db()->entry()->getFieldBudgetId() ),
                    Core::arrayAt( $row, Resource::db()->entry()->getFieldDate() ),
                    Core::arrayAt( $row, Resource::db()->entry()->getFieldAliasEntries() ),
                    Core::arrayAt( $row, Resource::db()->entry()->getFieldAliasCostSum() ),
                    Core::arrayAt( $row, Resource::db()->entry()->getFieldAliasCostTotal() ) );
            $entryMonth->setLastModified(
                    max(
                            array (
                                    Core::parseTimestamp(
                                            Core::arrayAt( $row, Resource::db()->entry()->getFieldUpdated() ) ),
                                    Core::parseTimestamp(
                                            Core::arrayAt( $row, Resource::db()->entry()->getFieldRegistered() ) ) ) ) );
            $entryMonths->add( $entryMonth );
        }

        return $entryMonths;

    }

    /**
     * @see EntryDao::getBudgets()
     */
    public function getBudgets( $budgetId )
    {
        $selectQuery = new SelectQueryDbCore( new SelectSqlbuilderDbCore() );

        $selectQuery->getQuery()->setExpression( Resource::db()->entry()->getFieldDate() );
        $selectQuery->getQuery()->addExpression( Resource::db()->entry()->getFieldType() );
        $selectQuery->getQuery()->addExpression( Resource::db()->entry()->getFieldCard() );
        $selectQuery->getQuery()->addExpression(
                SB::as_( SB::count( Resource::db()->entry()->getFieldId() ),
                        Resource::db()->entry()->getFieldAliasEntries() ) );
        $selectQuery->getQuery()->addExpression(
                $this->getCostSumExpression( Resource::db()->entry()->getTable(),
                        Resource::db()->entry()->getFieldAliasCostSum() ) );
        $selectQuery->getQuery()->setFrom( Resource::db()->entry()->getTable() );
        //         $selectQuery->getQuery()->addWhere(
        //                 SB::and_( SB::equ( SB::year( Resource::db()->entry()->getFieldDate() ), date( "Y", $month ) ),
        //                         SB::equ( SB::month( Resource::db()->entry()->getFieldDate() ), date( "m", $month ) ) ) );
        $selectQuery->getQuery()->addWhere(
                SB::equ( Resource::db()->entry()->getFieldBudgetId(), ":budgetId" ) );
        $selectQuery->getQuery()->setGroupBy( Resource::db()->entry()->getFieldCard(),
                Resource::db()->entry()->getFieldType(), SB::month( Resource::db()->entry()->getFieldDate() ),
                SB::year( Resource::db()->entry()->getFieldDate() ) );
        $selectQuery->getQuery()->setOrderBy( array ( array ( Resource::db()->entry()->getFieldDate(), SB::$DESC ) ) );

        $selectQuery->addBind( array ( "budgetId" => $budgetId ) );

        $result = $this->getDbApi()->query( $selectQuery );

        $budgetEntries = new IteratorCore();
        foreach ( $result->getRows() as $row )
        {
            $budgetEntries->add(
                    BudgetEntryFactoryModel::createEntryBudget(
                            Core::arrayAt( $row, Resource::db()->entry()->getFieldDate() ),
                            Core::arrayAt( $row, Resource::db()->entry()->getFieldAliasEntries() ),
                            Core::arrayAt( $row, Resource::db()->entry()->getFieldAliasCostSum() ),
                            Core::arrayAt( $row, Resource::db()->entry()->getFieldType() ),
                            Core::arrayAt( $row, Resource::db()->entry()->getFieldCard() ) ) );
        }

        return $budgetEntries;
    }

    /**
     * @see EntryDao::getMonth()
     */
    public function getMonth( $budgetId, $month )
    {

        $selectQuery = $this->getSelectQuery();

        $selectQuery->getQuery()->addWhere(
                SB::and_( SB::equ( SB::year( Resource::db()->entry()->getFieldDate() ), date( "Y", $month ) ),
                        SB::equ( SB::month( Resource::db()->entry()->getFieldDate() ), date( "m", $month ) ) ) );
        $selectQuery->getQuery()->addWhere( SB::equ( Resource::db()->entry()->getFieldBudgetId(), ":budgetId" ) );

        $selectQuery->addBind( array ( "budgetId" => $budgetId ) );

        $result = $this->getDbApi()->query( $selectQuery );

        return $this->createList( $result->getRows() );

    }

//     /**
//      * @see StandardDbDao::getForeign()
//      */
//     public function getForeign( array $foreignIds )
//     {
//         return $this->getMonth( Core::arrayAtIndex( 0, $foreignIds, 0 ) );
//     }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = EntryFactoryModel::createEntry( Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldCost() ),
                Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldType() ),
                Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldCard() ),
                Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldDate() ),
                Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldComment() ),
                Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldSingle() ),
                Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldCredit() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setBudgetId(
                intval( Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldBudgetId() ) ) );
        $model->setRegistered(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldRegistered() ) ) );
        $model->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->entry()->getFieldUpdated() ) ) );

        return $model;

    }

    // ... /CREATE


    // /FUNCTIONS


}

?>