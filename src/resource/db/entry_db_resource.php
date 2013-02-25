<?php

class EntryDbResource
{

    // VARIABLES


    private $table = "entry";

    private $fieldId = "entry_id";
    private $fieldBudgetId = "budget_id";
    private $fieldCost = "entry_cost";
    private $fieldComment = "entry_comment";
    private $fieldCredit = "entry_credit";
    private $fieldDate = "entry_date";
    private $fieldSingle = "entry_single";
    private $fieldType = "entry_type";
    private $fieldCard = "entry_card";
    private $fieldUpdated = "entry_updated";
    private $fieldRegistered = "entry_registered";

    private $fieldAliasEntries = "entry_entries";
    private $fieldAliasCostSum = "entry_cost_sum";
    private $fieldAliasCostTotal = "entry_cost_total";

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

    public function getFieldCost()
    {
        return $this->fieldCost;
    }

    public function getFieldCredit()
    {
        return $this->fieldCredit;
    }

    public function getFieldDate()
    {
        return $this->fieldDate;
    }

    public function getFieldSingle()
    {
        return $this->fieldSingle;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getFieldCard()
    {
        return $this->fieldCard;
    }

    public function getFieldUpdated()
    {
        return $this->fieldUpdated;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


    public function getFieldAliasEntries()
    {
        return $this->fieldAliasEntries;
    }

    public function getFieldAliasCostSum()
    {
        return $this->fieldAliasCostSum;
    }

    public function getFieldComment()
    {
        return $this->fieldComment;
    }

    public function getFieldAliasCostTotal()
    {
        return $this->fieldAliasCostTotal;
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