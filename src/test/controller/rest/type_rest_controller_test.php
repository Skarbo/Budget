<?php

class TypeRestControllerTest extends RestControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "TypeRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractStandardRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = TypeModel::get_( $modelOne );
        $modelTwo = TypeModel::get_( $modelTwo );

        $testCase->assertEqual( $modelOne->getTitle(), $modelTwo->getTitle() );
    }

    /**
     * @see AbstractStandardRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = TypeModel::get_( $model );

        $testCase->assertFalse( is_null( $model->getTitle() ) );
    }

    /**
     * @see AbstractStandardRestControllerTest::createModelTest()
     */
    protected function createModelTest()
    {
        return $this->getDaoContainer()->createType( "Type New" );
    }

    /**
     * @see AbstractStandardRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return TypeRestController::$CONTROLLER_NAME;
    }

    /**
     * @see AbstractStandardRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $model = TypeModel::get_( $model );

        $model->setTitle( "Type Edited" );

        return $model;
    }

    /**
     * @see AbstractStandardRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new TypeListModel();
    }

    /**
     * @see AbstractStandardRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return TypeFactoryModel::createTypeArray( $array );
    }

    /**
     * @see AbstractStandardRestControllerTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        return "";
    }

    /**
     * @see AbstractStandardRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getTypeDao();
    }

    /**
     * @see AbstractStandardRestControllerTest::testShouldGetListForeign()
     */
    public function testShouldGetListForeign()
    {
        // Not supported
    }

    /**
     * @see AbstractStandardRestControllerTest::testShouldGetListMultiple()
     */
    public function _testShouldGetListMultiple()
    {
        // Not supported
    }

    /**
     * @see AbstractStandardRestControllerTest::testShouldSearchList()
     */
    public function _testShouldSearchList()
    {
        // Not supported
    }


    public function testYShouldAddTypeWithLocale()
    {
        // Create Type
        $type = $this->getDaoContainer()->createType("Testing Øæå");

        // Post Entry
        $url = self::getRestWebsite( $this->getQueryAddSingle( null ) );

        $data = $this->post( $url, self::createPostStandard( $type ) );
        $dataArray = json_decode( $data, true );

                $this->showHeaders();
                $this->showRequest();
                $this->showSource();


        // Assert Entry
        if ( $this->assertResponse( AbstractController::STATUS_CREATED ) )
        {
            $typeRest = TypeFactoryModel::createTypeArray( self::getRestStandardSingle( $dataArray ) );

            if ( $this->assertFalse( empty( $typeRest ), "Type REST should not be empty" ) )
            {
                $this->assertEqual($type->getId(), $typeRest->getId());
                $this->assertEqual($type->getTitle(), $typeRest->getTitle());
            }

        }
    }

    // /FUNCTIONS



}

?>