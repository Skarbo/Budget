<?php

class AuthUserListModel extends StandardListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param string $type
     * @return AuthUserModel
     */
    public function getAuthUser( $type )
    {
        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $authUser = AuthUserModel::get_( $this->current() );
            if ( $authUser->getUserAuthType() == $type )
                return $authUser;
        }
        return null;
    }

    /**
     * @see IteratorCore::get()
     * @return AuthUserModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return AuthUserModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return AuthUserModel
     */
    public function current()
    {
        return parent::current();
    }

    // ... STATIC


    /**
     * @param AuthUserListModel $get
     * @return AuthUserListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>