<?php

class BudgetRestController extends RestController
{

    // VARIABLES


    const COMMAND_USER_ADD = "useradd";
    const COMMAND_USER_REMOVE = "userremove";

    public static $CONTROLLER_NAME = "budget";

    public static $FIELD_EMAIL = "user_email";
    public static $FIELD_USERID = "user_id";

    /**
     * @var BudgetValidator
     */
    private $budgetValidator;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see RestController::__construct()
     */
    public function __construct( AbstractApi $api, AbstractView $view )
    {
        parent::__construct( $api, $view );

        $this->budgetValidator = new BudgetValidator( $this->getLocale() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... IS


    private function isAddUserCommand()
    {
        return self::isPost() && self::getId() && self::getURI( self::URI_COMMAND ) == self::COMMAND_USER_ADD;
    }

    private function isRemoveUserCommand()
    {
        return self::isPost() && self::getId() && self::getURI( self::URI_COMMAND ) == self::COMMAND_USER_REMOVE;
    }

    // ... /IS


    /**
     * @see AbstractStandardRestController::getLastModified()
     */
    public function getLastModified()
    {
        return max( array ( parent::getLastModified(), filemtime( __FILE__ ) ) );
    }

    /**
     * @see AbstractStandardRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return null;
    }

    /**
     * @see AbstractStandardRestController::getModel()
     * @return BudgetModel
     */
    public function getModel()
    {
        return parent::getModel();
    }

    /**
     * @see AbstractStandardRestController::getModelPost()
     */
    protected function getModelPost()
    {
        $postObject = self::getPostObject();

        $budget = BudgetFactoryModel::createBudget( Core::arrayAt( $postObject, BudgetModel::TITLE ) );

        $this->budgetValidator->doValidate( $budget );

        return $budget;
    }

    /**
     * @see AbstractStandardRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getBudgetDao();
    }

    // ... DO


    /**
     * @see AbstractStandardRestController::doGetModel()
     */
    protected function doGetModel( $id )
    {
        return $this->getStandardDao()->getBudget( $id, $this->getUser()->getId() );
    }

    /**
     * @see AbstractStandardRestController::doGetAll()
     */
    protected function doGetAll()
    {
        return $this->getStandardDao()->getBudgets( $this->getUser()->getId() );
    }

    /**
     * @see AbstractStandardRestController::doGetForeign()
     */
    protected function doGetForeign( array $ids )
    {
        return $this->doGetAll();
    }

    /**
     * @see AbstractStandardRestController::doAddModel()
     */
    protected function doAddModel( StandardModel $model, $foreignId )
    {
        $budget = BudgetModel::get_( $model );
        $budget->setId( $this->getStandardDao()->add( $model, $foreignId ) );
        $this->getStandardDao()->addUser( $budget->getId(), $this->getUser()->getId() );
        return $budget;
    }

    // ... ... COMMAND


    /**
     * @see AbstractStandardRestController::doGetForeignCommand()
     */
    protected function doGetForeignCommand()
    {
        throw new UnsupportedException( "Foreign command not supported" );
    }

    /**
     * @see AbstractStandardRestController::doGetMultipleCommand()
     */
    protected function doGetMultipleCommand()
    {
        throw new UnsupportedException( "Get multiple command not supported" );
    }

    /**
     * @see AbstractStandardRestController::doSearchCommand()
     */
    protected function doSearchCommand()
    {
        throw new UnsupportedException( "Search command not supported" );
    }

    /**
     * @see AbstractStandardRestController::doRemoveCommand()
     */
    protected function doRemoveCommand()
    {
        $budgets = $this->doGetAll();

        if ( $budgets->size() == 1 )
        {
            throw new BadrequestException( "Can't delete the only Budget" );
        }

        parent::doRemoveCommand();
    }

    private function doBeforeUser()
    {
        $this->setModel( $this->doGetModel( self::getId() ) );

        if ( !$this->getModel() )
        {
            throw new BadrequestException( sprintf( "Budget \"%s\" does not exist", self::getId() ) );
        }
    }

    private function doAddUserCommand()
    {
        $this->doBeforeUser();

        $userEmail = Core::arrayAt( self::getPost(), self::$FIELD_EMAIL );

        if ( filter_var( $userEmail, FILTER_VALIDATE_EMAIL ) )
        {
            $this->getStandardDao()->addUser( $this->getModel()->getId(), null, $userEmail );
            $this->getStandardDao()->mergeUser();

            $this->setModel( $this->doGetModel( $this->getModel()->getId() ) );

            $this->setStatusCode( self::STATUS_CREATED );
        }
    }

    private function doRemoveUserCommand()
    {
        $this->doBeforeUser();

        // Can't delete the only User
        if ( count( $this->getModel()->getUsers() ) == 1 )
        {
            throw new BadrequestException( "Can't delete the only Budget User" );
        }

        $userId = Core::arrayAt( self::getPost(), self::$FIELD_USERID );
        $userEmail = Core::arrayAt( self::getPost(), self::$FIELD_EMAIL );
        if ( $userId )
        {
            $this->getStandardDao()->removeUser( $this->getModel()->getId(), $userId );
            $this->setStatusCode( self::STATUS_CREATED );
        }
        elseif ( $userEmail )
        {
            $this->getStandardDao()->removeUser( $this->getModel()->getId(), null, $userEmail );
            $this->setStatusCode( self::STATUS_CREATED );
        }

        $this->setModel( $this->doGetModel( $this->getModel()->getId() ) );
    }

    // ... ... /COMMAND


    // ... /DO


    /**
     * @see AbstractStandardRestController::request()
     */
    public function request()
    {
        if ( $this->isAddUserCommand() )
        {
            $this->doAddUserCommand();
        }
        else if ( $this->isRemoveUserCommand() )
        {
            $this->doRemoveUserCommand();
        }
        else
        {
            parent::request();
        }
    }

    // /FUNCTIONS


}

?>