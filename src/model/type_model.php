<?php

class TypeModel extends Model implements StandardModel
{

    // VARIABLES


    const ID = "id";
    const BUDGETID = "budgetid";
    const TITLE = "title";

    public $id;
    public $budgetId;
    public $title;
    private $updated;
    private $registered;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardModel::getForeignId()
     */
    public function getForeignId()
    {
        return $this->getBudgetId();
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
     * @param TypeModel $get
     * @return TypeModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated( $updated )
    {
        $this->updated = $updated;
    }

    /**
     * @return the $budgetId
     */
    public function getBudgetId()
    {
        return $this->budgetId;
    }

    /**
     * @param field_type $budgetId
     */
    public function setBudgetId( $budgetId )
    {
        $this->budgetId = $budgetId;
    }

}

?>