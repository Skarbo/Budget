<?php

class BudgetModel extends Model implements StandardModel
{

    // VARIABLES


    const ID = "id";
    const TITLE = "title";
    const UPDATED = "updated";
    const REGISTERED = "registered";

    public $id;
    public $title;
    private $updated;
    private $registered;
    public $users = array ();

    // /VARIABLES


    // CONSTRUCTOR


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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle( $title )
    {
        $this->title = $title;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated( $updated )
    {
        $this->updated = $updated;
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
     * @param BudgetModel $get
     * @return BudgetModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


    /**
     * @return the $users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param multitype: $users
     */
    public function setUsers( $users )
    {
        $this->users = $users;
    }

    public function addUser( array $user )
    {
        $this->users[] = $user;
    }

}

?>