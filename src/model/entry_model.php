<?php

class EntryModel extends Model implements StandardModel
{

    // VARIABLES


    const ID = "id";
    const BUDGETID = "budgetid";
    const COST = "cost";
    const COMMENT = "comment";
    const CREDIT = "credit";
    const DATE = "date";
    const SINGLE = "single";
    const TYPE = "type";
    const CARD = "card";
    const UPDATED = "updated";
    const REGISTERED = "registered";

    public $id;
    public $budgetId;
    public $monthId;
    public $cost;
    public $comment;
    public $credit;
    public $date;
    public $single;
    public $type;
    public $card;
    public $updated;
    public $registered;

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

    public function getCost()
    {
        return $this->cost;
    }

    public function setCost( $cost )
    {
        $this->cost = $cost;
    }

    public function getCredit()
    {
        return $this->credit;
    }

    public function setCredit( $credit )
    {
        $this->credit = $credit;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate( $date )
    {
        $this->date = $date;
    }

    public function getSingle()
    {
        return $this->single;
    }

    public function setSingle( $single )
    {
        $this->single = $single;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType( $type )
    {
        $this->type = $type;
    }

    public function getCard()
    {
        return $this->card;
    }

    public function setCard( $card )
    {
        $this->card = $card;
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
     * @param EntryModel $get
     * @return EntryModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


    public function getComment()
    {
        return $this->comment;
    }

    public function setComment( $comment )
    {
        $this->comment = $comment;
    }

    public function getMonthId()
    {
        return $this->monthId;
    }

    public function setMonthId( $monthId )
    {
        $this->monthId = $monthId;
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