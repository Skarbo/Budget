<?php

class BudgetCssResource extends ClassCore
{

    // VARIABLES


    private $entries = "entries";

    private $entriesHeader = "header";
    private $entriesEntry = "entry";

    private $entriesHeaderWrapper = "header_wrapper";
    private $entriesHeaderTitle = "title";
    private $entriesHeaderCounter = "counter";

    private $entryDate = "date";
    private $entryCost = "cost";
    private $entryType = "type";
    private $entryCard = "card";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getEntries()
    {
        return $this->entries;
    }

    public function getEntriesHeader()
    {
        return $this->entriesHeader;
    }

    public function getEntriesEntry()
    {
        return $this->entriesEntry;
    }

    public function getEntryDate()
    {
        return $this->entryDate;
    }

    public function getEntryCost()
    {
        return $this->entryCost;
    }

    public function getEntryType()
    {
        return $this->entryType;
    }

    public function getEntryCard()
    {
        return $this->entryCard;
    }

    public function getEntriesHeaderWrapper()
    {
        return $this->entriesHeaderWrapper;
    }

    public function getEntriesHeaderTitle()
    {
        return $this->entriesHeaderTitle;
    }

    public function getEntriesHeaderCounter()
    {
        return $this->entriesHeaderCounter;
    }

}

?>