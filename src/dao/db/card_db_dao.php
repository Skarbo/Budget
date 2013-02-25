<?php

class CardDbDao extends StandardDbDao implements CardDao
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
        return Resource::db()->card()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->card()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->card()->getFieldBudgetId();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();
        $model = CardModel::get_( $model );

        $fields[ Resource::db()->card()->getFieldTitle() ] = ":title";
        $binds[ "title" ] = Core::utf8Decode( $model->getTitle() );
        $fields[ Resource::db()->card()->getFieldBudgetId() ] = ":budgetId";
        $binds[ "budgetId" ] = $foreignId;
        $fields[ Resource::db()->card()->getFieldNumber() ] = ":number";
        $binds[ "number" ] = $model->getNumber();
        $fields[ Resource::db()->card()->getFieldJoint() ] = ":joint";
        $binds[ "joint" ] = $model->getJoint();

        if ( !$isInsert )
        {
            $fields[ Resource::db()->card()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new CardListModel();
    }

    /**
     * @see StandardDbDao::getSelectQuery()
     */
    protected function getSelectQuery()
    {
        $query = parent::getSelectQuery();

        $query->getQuery()->setOrderBy( array ( array ( Resource::db()->card()->getFieldTitle() ) ) );

        return $query;
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = CardFactoryModel::createCard( Core::arrayAt( $modelArray, Resource::db()->card()->getFieldTitle() ),
                Core::arrayAt( $modelArray, Resource::db()->card()->getFieldNumber() ),
                Core::arrayAt( $modelArray, Resource::db()->card()->getFieldJoint() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setBudgetId( intval( Core::arrayAt( $modelArray, Resource::db()->card()->getFieldBudgetId() ) ) );
        $model->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->card()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->card()->getFieldRegistered() ) ) );

        return $model;

    }

    // ... /CREATE


    // /FUNCTIONS


}

?>