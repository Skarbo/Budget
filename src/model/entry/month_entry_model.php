<?php

class MonthEntryModel extends Model implements StandardModel
{

    // VARIABLES


    public $id;
    public $budgetId;
    public $date;
    public $entries;
    public $costSum;
    public $budgets = array ();
    public $total = array ();
    private $lastModified = null;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getForeignId()
    {
        return null;
    }

    public function getLastModified()
    {
        return $this->lastModified;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function setDate( $date )
    {
        $this->date = $date;
    }

    public function setEntries( $entries )
    {
        $this->entries = $entries;
    }

    /**
     * @param MonthEntryModel $get
     * @return MonthEntryModel
     */
    public static function _get( $get )
    {
        return $get;
    }

    // /FUNCTIONS


    public function getCostSum()
    {
        return $this->costSum;
    }

    public function setCostSum( $costSum )
    {
        $this->costSum = $costSum;
    }

    /**
     * @param MonthEntryModel $get
     * @return MonthEntryModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    /**
     * @return array
     */
    public function getBudgets()
    {
        return $this->budgets;
    }

    public function setBudgets( array $budget )
    {
        $this->budgets = $budget;
    }

    /**
     * @param BudgetEntryModel $budget
     */
    public function addBudget( $cardId, $typeId, BudgetEntryModel $budget )
    {
        $this->budgets[ $cardId ][ $typeId ] = $budget;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal( $total )
    {
        $this->total = $total;
    }

    public function setLastModified( $lastModified )
    {
        $this->lastModified = $lastModified;
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