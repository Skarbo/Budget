<?php

define( "DB_PREFIX", "budget_" );

include_once '../krisskarboapi/src/util/initialize_util.php';
include_once '../krisskarboapi/src/api/api/abstract_api.php';

function __autoload( $class_name )
{
    try
    {
        $class_path = InitializeUtil::getClassPathFile( $class_name, dirname( __FILE__ ) );
        require_once ( $class_path );
    }
    catch ( Exception $e )
    {
        throw $e;
    }
}

// Initiate BudgetApi
$api = new BudgetApi( BudgetApi::MODE_DEV );

// Set Debug handler
$api->setDebug(
        array ( BudgetApi::MODE_DEV => DebugHandler::LEVEL_LOW, BudgetApi::MODE_PROD => DebugHandler::LEVEL_HIGH ) );

// Mapping
$mapping = array ();
$mapping[ BudgetMainController::$CONTROLLER_NAME ][ BudgetApi::MAP_CONTROLLER ] = BudgetMainController::class_();
$mapping[ BudgetMainController::$CONTROLLER_NAME ][ BudgetApi::MAP_VIEW ] = BudgetMainView::class_();
$mapping[ LoginMainController::$CONTROLLER_NAME ][ BudgetApi::MAP_CONTROLLER ] = LoginMainController::class_();
$mapping[ LoginMainController::$CONTROLLER_NAME ][ BudgetApi::MAP_VIEW ] = LoginMainView::class_();
$mapping[ "" ] = $mapping[ BudgetMainController::$CONTROLLER_NAME ];

// Create KillHandler
class MainKillHandler extends ClassCore implements KillHandler
{

    /**
     * @see KillHandler::handle()
     */
    public function handle( Exception $exception, ErrorHandler $error_handler )
    {
        // Exception type
        switch ( get_class( $exception ) )
        {
            case DbException::class_() :
                header( "HTTP/1.1 500 Internal Server Error" );
                break;

            default :
                header( "HTTP/1.1 500 Internal Server Error" );
                break;
        }

        die( "KillHandler: " . $exception->getMessage() );
    }

    /**
     * @see KillHandler::isAutoErrorLog()
     */
    public function isAutoErrorLog( Exception $exception )
    {
        return true;
    }

}

// Create OutputHandler
class MainOutputHandler extends OutputHandler
{

    /**
     * @see OutputHandler::handle()
     */
    public function handle( AbstractXhtml $output )
    {
        @header( "Content-Type: text/html; charset= UTF-8" );
        //$doctype = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
        //$doctype = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
        $doctype = "<!DOCTYPE HTML>\n";

        return "" . $doctype . $output;
    }

}

// Set Kill handler
$api->setKillHandler( new MainKillHandler() );

// Set Output handler
$api->setOutputHandler( new MainOutputHandler() );

// Do request
$api->doRequest( $mapping );

$api->destruct();

?>