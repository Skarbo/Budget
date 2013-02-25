<?php

class BudgetsRestView extends AbstractRestView
{

    // VARIABLES


    public static $FIELD_ENTRIES_MONTHS = "months";
    public static $FIELD_BUDGETS = "budgets";
    public static $FIELD_BUDGET = "budget";
    public static $FIELD_CARDS = "cards";
    public static $FIELD_TYPES = "types";
    public static $FIELD_USER = "user";
    public static $FIELD_INFO = "info";
    public static $FIELD_INFO_LAST_MODIFIED = "last_modified";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractView::getLastModified()
     */
    protected function getLastModified()
    {
        return max(
                array ( parent::getLastModified(), $this->getController()->getLastModified(), filemtime( __FILE__ ) ) );
    }

    /**
     * @see AbstractView::getController()
     * @return BudgetRestController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see AbstractRestView::getData()
     */
    public function getData()
    {

        // Initiate data
        $data = array ();

        // Budgets
        $data[ self::$FIELD_BUDGET ] = $this->getController()->getBudget()->getId();
        $data[ self::$FIELD_BUDGETS ] = $this->getController()->getBudgets()->getJson();

        // Budget
        $data[ self::$FIELD_ENTRIES_MONTHS ] = $this->getController()->getEntriesMonths()->getJson();

        $data[ self::$FIELD_CARDS ] = $this->getController()->getCards()->getJson();
        $data[ self::$FIELD_TYPES ] = $this->getController()->getTypes()->getJson();

        // User
        $this->getController()->getUser()->authUsers = $this->getController()->getUser()->getAuthUsers()->getArray();
        $data[ self::$FIELD_USER ] = $this->getController()->getUser();

        // Set last modified to data array
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_LAST_MODIFIED ] = sprintf( "%s GMT",
                gmdate( "D, d M Y H:i:s", $this->getLastModified() ) );

        // Return data
        return $data;

    }

    // /FUNCTIONS


}

?>