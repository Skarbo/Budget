<?php

ini_set( "display_errors", "1" );

class BudgetApi extends PasswordBudgetApi
{

    // VARIABLES




    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractApi::getLocale()
     * @return DefaultLocale
     */
    public function getLocale()
    {
        return parent::getLocale();
    }

    /**
     * @see AbstractApi::getDbbackupHandler()
     */
    protected function getDbbackupHandler()
    {

        // Get database config
        $databaseConfig = $this->getDatabaseConfig();

        list ( $dbHost, , $dbUser, $dbPassword ) = Core::arrayAt( $databaseConfig, self::MODE_TEST );

        // Get databases
        $databases = array_map(
                function ( $var )
                {
                    return Core::arrayAt( $var, 1 );
                }, $databaseConfig );

        return new DbbackupHandler( $dbHost, $dbUser, $dbPassword, $databases, realpath( "." ) );

    }

    // /FUNCTIONS


}

?>