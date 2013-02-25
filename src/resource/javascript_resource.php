<?php

class JavascriptResource extends AbstractJavascriptResource
{

    // VARIABLES


    private $budgetApiFile = "budget.js.php";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct();

        $this->budgetApiFile = sprintf( "%s/%s", self::$ROOT_FOLDER, $this->budgetApiFile );

    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getBudgetApiFile()
    {
        return $this->budgetApiFile;
    }

}

?>