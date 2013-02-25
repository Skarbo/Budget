<?php

class CardModel extends Model implements StandardModel
{

    // VARIABLES


    const ID = "id";
    const BUDGETID = "budgetid";
    const TITLE = "title";
    const NUMBER = "number";
    const JOINT = "joint";

    public $id;
    public $budgetId;
    public $title;
    public $number;
    public $joint;
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

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber( $number )
    {
        $this->number = $number;
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
     * @param CardModel $get
     * @return CardModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


    public function getJoint()
    {
        return $this->joint;
    }

    public function setJoint( $joint )
    {
        $this->joint = $joint;
    }

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