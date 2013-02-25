<?php

abstract class RestController extends AbstractStandardRestController implements InterfaceController
{

    // VARIABLES


    /**
     * @var DaoContainer
     */
    private $daoContainer;
    /**
     * @var LoginHandler
     */
    private $loginHandler;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see AbstractController::__construct()
     */
    public function __construct( AbstractApi $api, AbstractView $view )
    {
        parent::__construct( $api, $view );

        $this->daoContainer = new DaoContainer( $this->getDbApi() );
        $this->loginHandler = new LoginHandler( $this->getDaoContainer(), $this->getMode( true ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractStandardRestController::getLastModified()
     */
    public function getLastModified()
    {
        return max( parent::getLastModified(), $this->getUser()->getLastModified(), filemtime( __FILE__ ) );
    }

    /**
     * @return DaoContainer
     */
    public function getDaoContainer()
    {
        return $this->daoContainer;
    }

    /**
     * @see InterfaceController::getLoginHandler()
     */
    public function getLoginHandler()
    {
        return $this->loginHandler;
    }

    /**
     * @see InterfaceController::isLoginForce()
     */
    public function isLoginForce()
    {
        return true;
    }

    /**
     * @see InterfaceController::getUser()
     */
    public function getUser()
    {
        return $this->getLoginHandler()->getUser();
    }

    // ... /GET


    /**
     * @see AbstractStandardRestController::before()
     */
    public function before()
    {
        $this->getLoginHandler()->handle();

        if ( !$this->getLoginHandler()->isLoggedIn() && $this->isLoginForce() )
        {
            throw new UnauthorizedException( "Not logged in" );
        }

        parent::before();
    }

    // /FUNCTIONS


}

?>