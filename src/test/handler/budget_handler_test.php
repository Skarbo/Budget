<?php

class BudgetHandlerTest extends AbstractDbTest
{

    // VARIABLES


    public static $DB_CONFIG_LOCAL = array ( "localhost", "budget_test", "root", "" );

    /**
     * @var DaoContainerTest
     */
    private $daoContainer;
    /**
     * @var BudgetHandler
     */
    private $budgetHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "BudgetHandler Test" );

        $this->daoContainer = new DaoContainerTest( $this->getDbApi() );
        $this->budgetHandler = new BudgetHandler( $this->daoContainer );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractDbTest::getDatabaseConfig()
     */
    public function getDatabaseConfig()
    {
        return self::$DB_CONFIG_LOCAL;
    }

    // ... TEST


    public function testShould()
    {

    }

    // ... /TEST


    // /FUNCTIONS


}

?>