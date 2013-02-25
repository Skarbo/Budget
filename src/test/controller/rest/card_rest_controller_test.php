<?php

class CardRestControllerTest extends RestControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "CardRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractStandardRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = CardModel::get_($modelOne);
        $modelTwo = CardModel::get_($modelTwo);

        $testCase->assertEqual( $modelOne->getTitle(), $modelTwo->getTitle() );
        $testCase->assertEqual( $modelOne->getNumber(), $modelTwo->getNumber() );
        $testCase->assertEqual( $modelOne->getJoint(), $modelTwo->getJoint() );
    }

    /**
     * @see AbstractStandardRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = CardModel::get_( $model );

        $testCase->assertFalse( is_null( $model->getTitle() ) );
        $testCase->assertFalse( is_null( $model->getNumber() ) );
        $testCase->assertFalse( is_null( $model->getJoint() ) );
    }

    /**
     * @see AbstractStandardRestControllerTest::createModelTest()
     */
    protected function createModelTest()
    {
        return $this->getDaoContainer()->createCard( "Card New", "1234" );
    }

    /**
     * @see AbstractStandardRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return CardRestController::$CONTROLLER_NAME;
    }

    /**
     * @see AbstractStandardRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $model = CardModel::get_( $model );

        $model->setTitle( "Card Edited" );
        $model->setNumber( "4321" );
        $model->setJoint( 1 );

        return $model;
    }

    /**
     * @see AbstractStandardRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new CardListModel();
    }

    /**
     * @see AbstractStandardRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return CardFactoryModel::createCardArray( $array );
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
        return $this->getDaoContainer()->getCardDao();
    }

    /**
     * @see AbstractStandardRestControllerTest::testShouldGetListForeign()
     */
    public function testShouldGetListForeign()
    {
        // Not supported
    }

    // /FUNCTIONS


}

?>