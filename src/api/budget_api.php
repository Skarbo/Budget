<?php

ini_set( "display_errors", "1" );

class BudgetApi extends AbstractApi
{

    // VARIABLES


    public static $GOOGLE_CLIENT_ID = "605630038974.apps.googleusercontent.com";
    public static $GOOGLE_CLIENT_SECRET = "mUR-P95IncmZunoO45fNuKYw";
    public static $GOOGLE_DEVELOPER_KEY = "AIzaSyAi2eGQh6QKBcXWMpleO2rzl3p-VrLzgoE";

    public static $FACEBOOK_API_ID = "529380940427226";
    public static $FACEBOOK_API_SECRET = "7aa7e491296f274814e739229ee85dcb";

    private static $DB_CONFIG_PUBLIC = array (
            self::MODE_DEV => array ( "178.79.179.82", "budget_dev", "kris", "kris" ),
            self::MODE_PROD => array ( "178.79.179.82", "budget_prod", "kris", "kris" ),
            self::MODE_TEST => array ( "178.79.179.82", "budget_test", "kris", "kris" ) );
    //     private static $DB_CONFIG_LOCAL = array (
    //             self::MODE_DEV => array ( "kris-server", "budget_dev", "kris-win", "kris1234" ),
    //             self::MODE_PROD => array ( "kris-server", "budget_prod", "kris-win", "kris1234" ),
    //             self::MODE_TEST => array ( "kris-server", "budget_test", "kris-win", "kris1234" ) );
    private static $DB_CONFIG_LOCAL = array ( self::MODE_DEV => array ( "localhost", "budget_dev", "root", "" ),
            self::MODE_PROD => array ( "localhost", "budget_prod", "root", "" ),
            self::MODE_TEST => array ( "localhost", "budget_test", "root", "" ) );

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
     * @see AbstractApi::getDatabaseLocalConfig()
     */
    protected function getDatabaseLocalConfig()
    {
        return self::$DB_CONFIG_LOCAL;
    }

    /**
     * @see AbstractApi::getDatabasePublicConfig()
     */
    protected function getDatabasePublicConfig()
    {
        return self::$DB_CONFIG_PUBLIC;
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