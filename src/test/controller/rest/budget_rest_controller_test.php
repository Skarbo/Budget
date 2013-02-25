<?php

class BudgetRestControllerTest extends RestControllerTest
{

    // VARIABLES


    protected static $QUERY_ADD_USER = "%s/useradd/%s";
    protected static $QUERY_REMOVE_USER = "%s/userremove/%s";

    /**
     * @var LoginHandler
     */
    private $loginHandler;
    private $user;
    private $authUser;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "BudgetRestController Test" );

        $this->loginHandler = new LoginHandler( $this->getDaoContainer(), AbstractApi::MODE_TEST );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractStandardRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = BudgetModel::get_( $modelOne );
        $modelTwo = BudgetModel::get_( $modelTwo );

        $testCase->assertEqual( $modelOne->getTitle(), $modelTwo->getTitle() );
    }

    /**
     * @see AbstractStandardRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = BudgetModel::get_( $model );

        $testCase->assertFalse( is_null( $model->getTitle() ) );
    }

    /**
     * @see AbstractStandardRestControllerTest::createModelTest()
     */
    protected function createModelTest()
    {
        return $this->getDaoContainer()->createBudget( "Budget New" );
    }

    /**
     * @see AbstractStandardRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return BudgetRestController::$CONTROLLER_NAME;
    }

    /**
     * @see AbstractStandardRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $model = BudgetModel::get_( $model );

        $model->setTitle( "Budget Edited" );

        return $model;
    }

    /**
     * @see AbstractStandardRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new BudgetListModel();
    }

    /**
     * @see AbstractStandardRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return BudgetFactoryModel::createBudgetArray( $array );
    }

    /**
     * @see AbstractStandardRestControllerTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        return BudgetModel::get_( $model )->getTitle();
    }

    /**
     * @see AbstractStandardRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getBudgetDao();
    }

    /**
     * @see AbstractStandardRestControllerTest::testShouldGetListForeign()
     */
    public function testShouldGetListForeign()
    {
        // Not supported
    }

    /**
     * @see AbstractStandardRestControllerTest::testShouldSearchList()
     */
    public function testShouldSearchList()
    {
        // Not supported
    }

    /**
     * @see AbstractStandardRestControllerTest::testShouldGetListMultiple()
     */
    public function testShouldGetListMultiple()
    {
        // Not supported
    }

    /**
     * @see AbstractStandardRestControllerTest::doAddModel()
     */
    protected function doAddModel( $model, $foreignId )
    {
        $model = BudgetModel::get_( $model );
        $model->setId( $this->getStandardDao()->add( $model, $foreignId ) );
        $this->getStandardDao()->addUser( $model->getId(), $this->user->getId() );
        return $model;
    }

    /**
     * @see AbstractStandardRestControllerTest::doGetForeign()
     */
    protected function doGetForeign( $foreignId )
    {
        return $this->getStandardDao()->getBudgets( $this->user->getId() );
    }

    /**
     * @see AbstractControllerTest::setUp()
     */
    public function setUp()
    {
        parent::setUp();

        // Create user
        $this->user = $this->getDaoContainer()->addUser();

        // Create demo auth
        $this->authUser = $this->getDaoContainer()->addAuthUser( $this->user->getId(),
                AuthUserFactoryModel::createAuthUser( AuthUserModel::AUTH_TYPE_DEMO, $this->user->getId(),
                        AuthUserModel::AUTH_TYPE_DEMO ) );

        // Login demo user
        $this->setCookie( LoginHandler::$SESSION_DEMO, "true" );
    }

    // ... TEST


    public function testShouldAddBudgetUser()
    {
        $budget = $this->getDaoContainer()->addBudget();
        $this->getDaoContainer()->getBudgetDao()->addUser($budget->getId(), $this->user->getId());

        $url = self::getRestWebsite( sprintf( self::$QUERY_ADD_USER, $this->getControllerName(), $budget->getId() ) );

        // Do POST
        $data = $this->post( $url, array ( BudgetRestController::$FIELD_EMAIL => "testuser@email.com" ) );
        $dataArray = json_decode( $data, true );

//         $this->showHeaders();
//         $this->showRequest();
//         $this->showSource();
    }

    public function testShouldRemoveBudgetUserWithEmail()
    {
        $email = "testuser@email.com";
        $budget = $this->getDaoContainer()->addBudget();
        $this->getDaoContainer()->getBudgetDao()->addUser($budget->getId(), $this->user->getId());
		$this->getDaoContainer()->getBudgetDao()->addUser($budget->getId(), null, $email);

        $url = self::getRestWebsite( sprintf( self::$QUERY_REMOVE_USER, $this->getControllerName(), $budget->getId() ) );

        // Do POST
        $data = $this->post( $url, array ( BudgetRestController::$FIELD_EMAIL => $email ) );
        $dataArray = json_decode( $data, true );

//         $this->showHeaders();
//         $this->showRequest();
//         $this->showSource();

    }

    public function testShouldRemoveBudgetUserWithId()
    {
        $email = "testuser@email.com";
        $budget = $this->getDaoContainer()->addBudget();
        $this->getDaoContainer()->getBudgetDao()->addUser($budget->getId(), $this->user->getId());
		$this->getDaoContainer()->getBudgetDao()->addUser($budget->getId(), null, $email);

        $url = self::getRestWebsite( sprintf( self::$QUERY_REMOVE_USER, $this->getControllerName(), $budget->getId() ) );

        // Do POST
        $data = $this->post( $url, array ( BudgetRestController::$FIELD_USERID => $this->user->getId() ) );
        $dataArray = json_decode( $data, true );

//         $this->showHeaders();
//         $this->showRequest();
//         $this->showSource();
    }

    // ... /TEST


    // /FUNCTIONS


}

?>