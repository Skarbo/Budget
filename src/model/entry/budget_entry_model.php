<?php

class BudgetEntryModel extends Model
{

    // VARIABLES


    private $date = 0;
    public $entries = 0;
    public $costSum = 0;
    public $type = "";
    public $card = 0;
    public $prday = 0;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getId()
    {
        return $this->getYearMonth();
    }

    public function doPrDay()
    {
        if ( !$this->getDate() )
            return;
        $days = cal_days_in_month( CAL_GREGORIAN,
                intval( date( "m", $this->getDate() ) ), intval( date( "Y", $this->getDate() ) ) );
        $this->setPrday( round( $this->getCostSum() / $days, 2) );
    }

    public function getYearMonth()
    {
        return $this->getDate() ? date( "ym", $this->getDate() ) : 0;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function getCostSum()
    {
        return $this->costSum;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCard()
    {
        return $this->card;
    }

    public function setEntries( $entries )
    {
        $this->entries = $entries;
    }

    public function setCostSum( $costSum )
    {
        $this->costSum = $costSum;
    }

    public function setType( $type )
    {
        $this->type = $type;
    }

    public function setCard( $card )
    {
        $this->card = $card;
    }

    /**
     * @param BudgetEntryModel $get
     * @return BudgetEntryModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate( $date )
    {
        $this->date = $date;
    }

    public function getPrday()
    {
        return $this->prday;
    }

    public function setPrday( $prday )
    {
        $this->prday = $prday;
    }

}

?>