<?php

class AuthUserModel extends Model implements StandardModel
{

    // VARIABLES


    const AUTH_TYPE_DEMO = "demo";
    const AUTH_TYPE_GOOGLE = "google";
    const AUTH_TYPE_FACEBOOK = "facebook";

    const USERID = "userId";
    const USERAUTHTYPE = "userAuthType";
    const USERAUTHLOGGEDIN = "userAuthLoggedin";
    const USERAUTHREGISTERED = "userAuthRegistered";

    public $userId;
    public $id;
    public $type;
    public $loggedin;
    private $registered;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardModel::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @see StandardModel::setId()
     */
    public function setId( $id )
    {
        $this->id = $id;
    }

    /**
     * @see StandardModel::getForeignId()
     */
    public function getForeignId()
    {
        return $this->getUserId();
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId( $userId )
    {
        $this->userId = $userId;
    }

    public function getUserAuthType()
    {
        return $this->type;
    }

    public function setUserAuthType( $userAuthType )
    {
        $this->type = $userAuthType;
    }

    public function getUserAuthLoggedin()
    {
        return $this->loggedin;
    }

    public function setUserAuthLoggedin( $userAuthLoggedin )
    {
        $this->loggedin = $userAuthLoggedin;
    }

    public function getUserAuthRegistered()
    {
        return $this->registered;
    }

    public function setUserAuthRegistered( $userAuthRegistered )
    {
        $this->registered = $userAuthRegistered;
    }

    /**
     * @see StandardModel::getLastModified()
     */
    public function getLastModified()
    {
        return $this->getUserAuthLoggedin();
    }

    // ... STATIC


    /**
     * @param AuthUserModel $get
     * @return AuthUserModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>