<?php

header('Content-Type: text/html; charset=utf-8');

define( "DB_PREFIX", "budget_" );

include_once '../KrisSkarboApi/src/util/initialize_util.php';
include_once '../KrisSkarboApi/src/api/api/abstract_api.php';
include_once '../KrisSkarboApi/src/api/simplehtmldom_api.php';
include_once '../SimpleTest/simpletest/autorun.php';
include_once '../SimpleTest/simpletest/web_tester.php';


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

class AllTests extends TestSuite
{

    public function __construct()
    {

        parent::TestSuite( "All tests" );

        $this->add( new BudgetRestControllerTest() );
        //$this->add( new EntryRestControllerTest() );
//         $this->add( new CardRestControllerTest() );
//         $this->add( new TypeRestControllerTest() );
// $this->add(new BudgetStandardDaoTest());
// $this->add(new UserStandardDaoTest());

    }

}

?>