<?php

class BudgetStandardDaoTest extends StandardDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see StandardDaoTest::__construct()
     */
    public function __construct()
    {
        parent::__construct( "BudgetStandardDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractStandardDaoTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = BudgetModel::get_( $modelOne );
        $modelTwo = BudgetModel::get_( $modelTwo );

        self::assertEqualsFunction( $modelOne->getId(), $modelTwo->getId(), "Budget id", $testCase );
        self::assertEqualsFunction( $modelOne->getTitle(), $modelTwo->getTitle(), "Budget title", $testCase );
    }

    /**
     * @see AbstractStandardDaoTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = BudgetModel::get_( $model );

        self::assertNotNullFunction( $model->getId(), "Budget id", $testCase );
        self::assertNotNullFunction( $model->getTitle(), "Budget title", $testCase );
    }

    /**
     * @see AbstractStandardDaoTest::createModelTest()
     */
    protected function createModelTest()
    {
        return BudgetFactoryModel::createBudget( "Budget Test" );
    }

    /**
     * @see AbstractStandardDaoTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $model = BudgetModel::get_( $model );

        $model->setTitle( "Budget Updated" );

        return $model;
    }

    /**
     * @see AbstractStandardDaoTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        return BudgetModel::get_( $model )->getTitle();
    }

    /**
     * @see AbstractStandardDaoTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getBudgetDao();
    }

    // ... TEST


    /**
     * @see AbstractStandardDaoTest::testShouldGetForeign()
     */
    public function testShouldGetForeign()
    {
        // Not supported
    }

    public function testShouldAddUserWithUserId()
    {
        $budget = $this->getDaoContainer()->addBudget();
        $user = $this->getDaoContainer()->addUser();
        $userAdded = $this->getStandardDao()->addUser( $budget->getId(), $user->getId() );
        $this->assertTrue( $userAdded );
    }

    public function testShouldAddUserWithUserEmail()
    {
        $budget = $this->getDaoContainer()->addBudget();
        $userAdded = $this->getStandardDao()->addUser( $budget->getId(), null, "test@email.com" );
        $this->assertTrue( $userAdded );
    }

    public function testShouldEditUserWithUserEmail()
    {
        $budget = $this->getDaoContainer()->addBudget();
        $user = $this->getDaoContainer()->addUser();
        $this->getStandardDao()->addUser( $budget->getId(), null, "test@email.com" );
        $userEdited = $this->getStandardDao()->editUser( $budget->getId(), null, "test@email.com", $user->getId(),
                "test@email.com" );
        $this->assertEqual( $userEdited, 1 );
    }

    public function testShouldRemoveUserWithUserId()
    {
        $budget = $this->getDaoContainer()->addBudget();
        $user = $this->getDaoContainer()->addUser();
        $this->getStandardDao()->addUser( $budget->getId(), $user->getId() );
        $userRemoved = $this->getStandardDao()->removeUser( $budget->getId(), $user->getId() );
        $this->assertEqual( $userRemoved, 1 );
    }

    public function testShouldMerge()
    {
        $budget = $this->getDaoContainer()->addBudget();
        $user = $this->getDaoContainer()->addUser( UserFactoryModel::createUser( "User Test", "test@email.com" ) );
        $userAdded = $this->getStandardDao()->addUser( $budget->getId(), null, "test@email.com" );
        if ( $this->assertTrue( $userAdded ) )
        {
            $mergedUsers = $this->getStandardDao()->mergeUser();
            $this->assertEqual( $mergedUsers, 1 );
        }
    }

    // ... /TEST


    // /FUNCTIONS


}

?>