<?php

class CssResource extends AbstractCssResource
{

    // VARIABLES


    private static $BUDGET;

    private $budgetFile = "budget.css.php";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct();

        $this->budgetFile = sprintf( "%s/%s", self::$ROOT_FOLDER, $this->budgetFile );

    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return BudgetCssResource
     */
    public function budget()
    {
        self::$BUDGET = self::$BUDGET ? self::$BUDGET : new BudgetCssResource();
        return self::$BUDGET;
    }

    public function getBudgetFile()
    {
        return $this->budgetFile;
    }

}

?>