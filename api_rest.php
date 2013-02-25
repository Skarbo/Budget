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

// Generate mode
$mode = isset( $_GET[ "mode" ] ) && in_array( $_GET[ "mode" ], BudgetApi::$MODES ) ? $_GET[ "mode" ] : BudgetApi::MODE_DEV;

// Initiate BudgetApi
$api = new BudgetApi( $mode );

// Set Debug handler
$api->setDebug(
        array ( BudgetApi::MODE_TEST => DebugHandler::LEVEL_LOW, BudgetApi::MODE_DEV => DebugHandler::LEVEL_LOW,
                BudgetApi::MODE_PROD => DebugHandler::LEVEL_HIGH ) );

// Mapping
$mapping = array ();
$mapping[ EntryRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_CONTROLLER ] = EntryRestController::class_();
$mapping[ EntryRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_VIEW ] = RestView::class_();
$mapping[ CardRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_CONTROLLER ] = CardRestController::class_();
$mapping[ CardRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_VIEW ] = RestView::class_();
$mapping[ TypeRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_CONTROLLER ] = TypeRestController::class_();
$mapping[ TypeRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_VIEW ] = RestView::class_();
$mapping[ BudgetRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_CONTROLLER ] = BudgetRestController::class_();
$mapping[ BudgetRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_VIEW ] = RestView::class_();
$mapping[ BudgetsRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_CONTROLLER ] = BudgetsRestController::class_();
$mapping[ BudgetsRestController::$CONTROLLER_NAME ][ BudgetApi::MAP_VIEW ] = BudgetsRestView::class_();
$mapping[ "" ] = $mapping[ BudgetsRestController::$CONTROLLER_NAME ];

// Create KillHandler
class BudgetApirestKillHandler extends ClassCore implements KillHandler
{

    /**
     * @see KillHandler::handle()
     */
    public function handle( Exception $exception, ErrorHandler $error_handler )
    {

        // Set JSON as content type
        @header( sprintf( "Content-type: %s;charset=%s", "application/json", "utf-8" ) );

        // Initiate JSON array
        $json = array ();
        $json[ "error" ] = array ();
        $json[ "error" ][ "title" ] = "Error";
        $json[ "error" ][ "text" ] = $exception->getMessage();

        // Exception type
        switch ( get_class( $exception ) )
        {
            case DbException::class_() :
                @header( "HTTP/1.1 500 Internal Server Error" );
                break;

            case BadrequestException::class_() :
                @header( "HTTP/1.1 400 Bad Request" );
                $json[ "error" ][ "title" ] = "Bad request";
                break;

            case ValidatorException::class_() :
                @header( "HTTP/1.1 400 Bad Request" );
                $json[ "error" ][ "title" ] = "Validation error";
                $json[ "error" ][ "validations" ] = implode( "\n",
                        Core::arrayEmpty( ValidatorException::get_( $exception )->getValidations() ) );
                break;

            case UnauthorizedException::class_() :
                @header( "HTTP/1.1 401 Unauthorized" );
                $json[ "error" ][ "title" ] = "Unauthorized access";
                break;

            case UnsupportedException::class_() :
                @header( "HTTP/1.1 400 Bad Request" );
                $json[ "error" ][ "title" ] = "Unsupported query";
                break;

            default :
                @header( "HTTP/1.1 500 Internal Server Error" );
                break;
        }

        // Print JSON


        die( json_encode( $json, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP ) );

    }

    /**
     * @see KillHandler::isAutoErrorLog()
     */
    public function isAutoErrorLog( Exception $exception )
    {
        switch ( get_class( $exception ) )
        {
            case DbException::class_() :
            case "Exception" :
                return true;

            default :
                return false;
        }
    }

}

// Create OutputHandler
class BudgetApirestOutputHandler extends OutputHandler
{

    /**
     * @see OutputHandler::handle()
     */
    public function handle( AbstractXhtml $output )
    {

        if ( $output == null )
        {
            return "";
        }

        return $output->get_content();

    }

}

// Set Kill handler
$api->setKillHandler( new BudgetApirestKillHandler() );

// Set Output handler
$api->setOutputHandler( new BudgetApirestOutputHandler() );

// Do request
$api->doRequest( $mapping );

$api->destruct();

?>