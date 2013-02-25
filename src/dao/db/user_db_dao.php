<?php

class UserDbDao extends StandardDbDao implements UserDao
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
        return Resource::db()->user()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->user()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return null;
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();
        $model = UserModel::get_( $model );

        $fields[ Resource::db()->user()->getFieldName() ] = ":userName";
        $binds[ "userName" ] = Core::utf8Decode( $model->getName() );
        $fields[ Resource::db()->user()->getFieldEmail() ] = ":userEmail";
        $binds[ "userEmail" ] = Core::utf8Decode( $model->getEmail() );

        if ( !$isInsert )
        {
            $fields[ Resource::db()->user()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new UserListModel();
    }

    /**
     * @see StandardDbDao::getSelectQuery()
     */
    protected function getSelectQuery()
    {
        $selectQuery = parent::getSelectQuery();

        $selectAuthBuilder = new SelectSqlbuilderDbCore(
                SB::groupConcat(
                        Core::cc( " ", SB::$DISTINCT,
                                SB::concat( ",", Resource::db()->authUser()->getFieldUserAuthId(),
                                        Resource::db()->authUser()->getFieldUserAuthType(),
                                        Resource::db()->authUser()->getFieldUserAuthLoggedin() ) ), SB::$ORDER_BY,
                        Resource::db()->authUser()->getFieldUserAuthLoggedin(), SB::$SEPARATOR, SB::quote( "|" ) ),
                Resource::db()->authUser()->getTable(),
                SB::equ(
                        SB::pun( Resource::db()->authUser()->getTable(), Resource::db()->authUser()->getFieldUserId() ),
                        SB::pun( Resource::db()->user()->getTable(), Resource::db()->user()->getFieldId() ) ),
                Resource::db()->authUser()->getFieldUserId() );

        $selectQuery->getQuery()->addExpression(
                SB::as_( SB::par( $selectAuthBuilder->build() ), Resource::db()->user()->getFieldAliasAuthUsers() ) );

        return $selectQuery;
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = UserFactoryModel::createUser( Core::arrayAt( $modelArray, Resource::db()->user()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->user()->getFieldEmail() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setLoggedin(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->user()->getFieldLoggedin() ) ) );
        $model->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->user()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->user()->getFieldRegistered() ) ) );

        // Auth users
        $authUserAlias = Core::arrayAt( $modelArray, Resource::db()->user()->getFieldAliasAuthUsers() );
        $authUserExploded = explode( "|", $authUserAlias );

        foreach ( $authUserExploded as $authUser )
        {
            $authUserArray = explode( ",", $authUser );
            $model->getAuthUsers()->add(
                    AuthUserFactoryModel::createAuthUser( Core::arrayAt( $authUserArray, 0 ), $model->getId(),
                            Core::arrayAt( $authUserArray, 1 ), Core::arrayAt( $authUserArray, 2 ) ) );
        }

        return $model;

    }

    // ... /CREATE


    /**
     * @see UserDao::setLoggedin()
     */
    public function setLoggedin( $id )
    {
        $updateQuery = new UpdateQueryDbCore();

        $updateBuilder = new UpdateSqlbuilderDbCore( $this->getTable(),
                array ( Resource::db()->user()->getFieldLoggedin() => SB::$CURRENT_TIMESTAMP ),
                SB::equ( Resource::db()->user()->getFieldId(), ":id" ) );
        $updateQuery->setQuery( $updateBuilder );

        $updateQuery->addBind( array ( "id" => $id ) );

        $result = $this->getDbApi()->query( $updateQuery );
        return $result->isExecute();
    }

    // /FUNCTIONS


}

?>