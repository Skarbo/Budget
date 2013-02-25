<?php

class TypeDbResource
{

    // VARIABLES


    private $table = "type";

    private $fieldId = "type_id";
    private $fieldBudgetId = "budget_id";
    private $fieldTitle = "type_title";
    private $fieldUpdated = "type_updated";
    private $fieldRegistered = "type_registered";

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

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


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