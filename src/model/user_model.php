<?php

class UserModel extends Model implements StandardModel
{

    // VARIABLES


    const ID = "id";
    const NAME = "name";
    const EMAIL = "email";
    const LOGGEDIN = "loggedin";
    const UPDATED = "updated";
    const REGISTERED = "registered";

    public $id;
    public $name;
    public $email;
    public $loggedin;
    private $updated;
    private $registered;

    /**
     * @var AuthUserListModel
     */
    private $authUsersList;
    public $authUsers = array ();

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see Model::__construct()
     */
    public function __construct( $a = array() )
    {
        parent::__construct( $a );

        $this->authUsersList = new AuthUserListModel();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardModel::getForeignId()
     */
    public function getForeignId()
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getLoggedin()
    {
        return $this->loggedin;
    }

    public function setLoggedin( $loggedin )
    {
        $this->loggedin = $loggedin;
    }

    public function getRegistered()
    {
        return $this->registered;
    }

    public function setRegistered( $registered )
    {
        $this->registered = $registered;
    }

    /**
     * @see StandardModel::getLastModified()
     */
    public function getLastModified()
    {
        return max( $this->getUpdated(), $this->getRegistered() );
    }

    // ... STATIC


    /**
     * @param UserModel $get
     * @return UserModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


    /**
     * @return AuthUserListModel
     */
    public function getAuthUsers()
    {
        return $this->authUsersList;
    }

    /**
     * @param AuthUserListModel $authUsers
     */
    public function setAuthUsers( AuthUserListModel $authUsers )
    {
        $this->authUsersList = $authUsers;
    }

    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return the $updated
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param field_type $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @param field_type $email
     */
    public function setEmail( $email )
    {
        $this->email = $email;
    }

    /**
     * @param field_type $updated
     */
    public function setUpdated( $updated )
    {
        $this->updated = $updated;
    }

}

?>