<?php

class CardDbResource
{

    // VARIABLES


    private $table = "card";

    private $fieldId = "card_id";
    private $fieldBudgetId = "budget_id";
    private $fieldTitle = "card_title";
    private $fieldNumber = "card_number";
    private $fieldJoint = "card_joint";
    private $fieldUpdated = "card_updated";
    private $fieldRegistered = "card_registered";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getTable()
    {
        return Core::constant( "DB_PREFIX" ) . $this->table;
    }

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getFieldTitle()
    {
        return $this->fieldTitle;
    }

    public function getFieldNumber()
    {
        return $this->fieldNumber;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


    public function getFieldJoint()
    {
        return $this->fieldJoint;
    }

    public function getFieldUpdated()
    {
        return $this->fieldUpdated;
    }

    /**
     * @return the $fieldBudgetId
     */
    public function getFieldBudgetId()
    {
        return $this->fieldBudgetId;
    }

}

?>