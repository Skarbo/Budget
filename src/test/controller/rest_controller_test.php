<?php

abstract class RestControllerTest extends AbstractStandardRestControllerTest
{

    // VARIABLES


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
     * @return DaoContainerTest
     */
    public function getDaoContainer()
    {
        return $this->daoContainer;
    }

    /**
     * @see AbstractWebTest::getDatabaseConfig()
     */
    public function getDatabaseConfig()
    {
        return ControllerTest::$DB_CONFIG_LOCAL;
    }

    // /FUNCTIONS


}

?>