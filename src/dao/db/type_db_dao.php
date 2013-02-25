<?php

class TypeDbDao extends StandardDbDao implements TypeDao
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
        return Resource::db()->type()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->type()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->type()->getFieldBudgetId();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();
        $model = TypeModel::get_( $model );

        $fields[ Resource::db()->type()->getFieldId() ] = ":id";
        $binds[ "id" ] = $model->getId();
        $fields[ Resource::db()->card()->getFieldBudgetId() ] = ":budgetId";
        $binds[ "budgetId" ] = $foreignId;
        $fields[ Resource::db()->type()->getFieldTitle() ] = ":title";
        $binds[ "title" ] = Core::utf8Decode( $model->getTitle() );

        if ( !$isInsert )
        {
            $fields[ Resource::db()->type()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new TypeListModel();
    }

    /**
     * @see StandardDbDao::getSelectQuery()
     */
    protected function getSelectQuery()
    {
        $query = parent::getSelectQuery();

        $query->getQuery()->setOrderBy( array ( array ( Resource::db()->type()->getFieldTitle() ) ) );

        return $query;
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = TypeFactoryModel::createType( Core::arrayAt( $modelArray, Resource::db()->type()->getFieldTitle() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setBudgetId( intval( Core::arrayAt( $modelArray, Resource::db()->type()->getFieldBudgetId() ) ) );
        $model->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->type()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->type()->getFieldRegistered() ) ) );

        return $model;

    }

    // ... /CREATE


    // /FUNCTIONS


}

?>