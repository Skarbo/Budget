<?php

abstract class StandardDaoTest extends AbstractStandardDaoTest
{

    // VARIABLES


    public static $DB_CONFIG_LOCAL = array ( "localhost", "budget_test", "root", "" );

    /**
     * @var DaoContainerTest
     */
    private $daoContainer;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see AbstractDbTest::__construct()
     */
    public function __construct( $label )
    {
        parent::__construct( $label );

        $this->daoContainer = new DaoContainerTest( $this->getDbApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractDaoTest::getDaoContainer()
     * @return DaoContainerTest
     */
    public function getDaoContainer()
    {
        return $this->daoContainer;
    }

    /**
     * @see AbstractDbTest::getDatabaseConfig()
     */
    public function getDatabaseConfig()
    {
        return self::$DB_CONFIG_LOCAL;
    }

    // /FUNCTIONS

}

?>