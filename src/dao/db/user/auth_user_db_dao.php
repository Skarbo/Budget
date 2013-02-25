<?php

class AuthUserDbDao extends StandardDbDao implements AuthUserDao
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
        return Resource::db()->authUser()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->authUser()->getFieldUserAuthId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->authUser()->getFieldUserId();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();
        $model = AuthUserModel::get_( $model );

        $fields[ Resource::db()->authUser()->getFieldUserId() ] = ":userId";
        $binds[ "userId" ] = $model->getUserId();
        $fields[ Resource::db()->authUser()->getFieldUserAuthId() ] = ":userAuthId";
        $binds[ "userAuthId" ] = $model->getId();
        $fields[ Resource::db()->authUser()->getFieldUserAuthType() ] = ":userAuthType";
        $binds[ "userAuthType" ] = $model->getUserAuthType();

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new AuthUserListModel();
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = AuthUserFactoryModel::createAuthUser(
                Core::arrayAt( $modelArray, Resource::db()->authUser()->getFieldUserAuthId() ),
                Core::arrayAt( $modelArray, Resource::db()->authUser()->getFieldUserId() ),
                Core::arrayAt( $modelArray, Resource::db()->authUser()->getFieldUserAuthType() ),
                Core::arrayAt( $modelArray, Resource::db()->authUser()->getFieldUserAuthName() ),
                Core::arrayAt( $modelArray, Resource::db()->authUser()->getFieldUserAuthEmail() ) );

        $model->setUserAuthLoggedin(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->authUser()->getFieldUserAuthLoggedin() ) ) );
        $model->setUserAuthRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->authUser()->getFieldUserAuthRegistered() ) ) );

        return $model;

    }

    // ... /CREATE


    /**
     * @see AuthUserDao::getUser()
     */
    public function getUser( $authId, $type )
    {

        $selectQuery = $this->getSelectQuery();

        $selectQuery->getQuery()->addWhere( SB::equ( Resource::db()->authUser()->getFieldUserAuthId(), ":authId" ) );
        $selectQuery->getQuery()->addWhere( SB::equ( Resource::db()->authUser()->getFieldUserAuthType(), ":type" ) );

        $selectQuery->addBind( array ( "authId" => $authId, "type" => $type ) );

        $result = $this->getDbApi()->query( $selectQuery );

        return $result->getSizeRows() > 0 ? $this->createModel( $result->getRow( 0 ) ) : null;

    }

    /**
     * @see UserDao::setLoggedin()
     */
    public function setLoggedin( $userId, $type )
    {
        $updateQuery = new UpdateQueryDbCore();

        $updateBuilder = new UpdateSqlbuilderDbCore( $this->getTable(),
                array ( Resource::db()->authUser()->getFieldUserAuthLoggedin() => SB::$CURRENT_TIMESTAMP ),
                SB::and_( SB::equ( Resource::db()->authUser()->getFieldUserId(), ":userId" ),
                        SB::equ( Resource::db()->authUser()->getFieldUserAuthType(), ":type" ) ) );
        $updateQuery->setQuery( $updateBuilder );

        $updateQuery->addBind( array ( "userId" => $userId, "type" => $type ) );

        $result = $this->getDbApi()->query( $updateQuery );
        return $result->isExecute();
    }

    // /FUNCTIONS


}

?>