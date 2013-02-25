<?php

class ControllerTest extends AbstractControllerTest
{

    // VARIABLES


    public static $DB_CONFIG_LOCAL = array ( "localhost", "budget_test", "root", "" );

    /**
     * @var DaoContainerTest
     */
    private $daoContainer;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $label )
    {
        parent::__construct( $label );

        $this->daoContainer = new DaoContainerTest( $this->getDbApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see DaoContainerTest
     */
    public function getDaoContainer()
    {
        return $this->daoContainer;
    }

    public function getDatabaseConfig()
    {
        return self::$DB_CONFIG_LOCAL;
    }

    // /FUNCTIONS


}

?>