<?php

class UserStandardDaoTest extends StandardDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see StandardDaoTest::__construct()
     */
    public function __construct()
    {
        parent::__construct( "UserStandardDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractStandardDaoTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = UserModel::get_( $modelOne );
        $modelTwo = UserModel::get_( $modelTwo );

        self::assertEqualsFunction( $modelOne->getId(), $modelTwo->getId(), "User id", $testCase );
        self::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "User name", $testCase );
        self::assertEqualsFunction( $modelOne->getEmail(), $modelTwo->getEmail(), "User email", $testCase );
    }

    /**
     * @see AbstractStandardDaoTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = UserModel::get_( $model );

        self::assertNotNullFunction( $model->getId(), "User id", $testCase );
        self::assertNotNullFunction( $model->getName(), "User name", $testCase );
        self::assertNotNullFunction( $model->getEmail(), "User email", $testCase );
    }

    /**
     * @see AbstractStandardDaoTest::createModelTest()
     */
    protected function createModelTest()
    {
        return UserFactoryModel::createUser( "User Test", "test@email.com" );
    }

    /**
     * @see AbstractStandardDaoTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $model = UserModel::get_( $model );

        $model->setName( "User Edited" );
        $model->setEmail( "update@email.com" );

        return $model;
    }

    /**
     * @see AbstractStandardDaoTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        return UserModel::get_( $model )->getName();
    }

    /**
     * @see AbstractStandardDaoTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getUserDao();
    }

    // ... TEST


    /**
     * @see AbstractStandardDaoTest::testShouldGetForeign()
     */
    public function testShouldGetForeign()
    {
        // Not supported
    }

    public function testShouldGetAuthUsers()
    {
        $user = $this->getDaoContainer()->addUser();
        $authUser = $this->getDaoContainer()->addAuthUser( $user->getId() );
        $user = UserModel::get_( $this->getStandardDao()->get( $user->getId() ) );

        if ( $this->assertNotNull( $user ) )
        {
            if ( $this->assertEqual( $user->getAuthUsers()->size(), 1 ) )
            {
                $authUserGot = $user->getAuthUsers()->get( 0 );

                $this->assertEqual( $authUserGot->getId(), $authUser->getId() );
                $this->assertEqual( $authUserGot->getUserAuthType(), $authUser->getUserAuthType() );
            }
        }
    }

    // ... /TEST


    // /FUNCTIONS


}

?>