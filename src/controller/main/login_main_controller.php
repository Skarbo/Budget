<?php

class LoginMainController extends MainController implements LoginInterface
{

    // VARIABLES


    public static $CONTROLLER_NAME = "login";

    const URI_PAGE = 1;

    const PAGE_LOGIN = "login";
    const PAGE_GOOGLE = "google";
    const PAGE_FACEBOOK = "facebook";
    const PAGE_DEMO = "demo";
    const PAGE_LOGOUT = "logout";

    const QUERY_CODE_GOOGLE = "code";

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see MainController::__construct()
     */
    public function __construct( AbstractApi $api, AbstractView $view )
    {
        parent::__construct( $api, $view );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see MainController::getTitle()
     */
    protected function getTitle()
    {
        return sprintf( "Login - %s", parent::getTitle() );
    }

    /**
     * @see MainController::getJavascriptController()
     */
    protected function getJavascriptController()
    {
        return "LoginMainController";
    }

    /**
     * @see MainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "LoginMainView";
    }

    /**
     * @see MainController::getViewId()
     */
    protected function getViewId()
    {
        return LoginMainView::$ID_BUDGET_WRAPPER;
    }

    /**
     * @see LoginInterface::getGoogleAuthUrl()
     */
    public function getGoogleAuthUrl()
    {
        return $this->getLoginHandler()->getGoogleApi()->createAuthUrl();
    }

    /**
     * @see LoginInterface::getFacebookAuthUrl()
     */
    public function getFacebookAuthUrl()
    {
        return $this->getLoginHandler()->getFacebookApi()->getLoginUrl();
    }

    private function getQueryCodeGoogle()
    {
        return Core::arrayAt( self::getQuery(), self::QUERY_CODE_GOOGLE );
    }

    /**
     * @see LoginInterface::getUser()
     */
    public function getUser()
    {
        return $this->getLoginHandler()->getUser();
    }

    // ... /GET


    // ... IS


    /**
     * @return boolean True if page is login
     */
    public function isPageLogin()
    {
        return self::getURI( self::URI_PAGE ) == self::PAGE_LOGIN || !self::getURI( self::URI_PAGE );
    }

    /**
     * @return boolean True if page is Google
     */
    public function isPageGoogle()
    {
        return self::getURI( self::URI_PAGE ) == self::PAGE_GOOGLE;
    }

    /**
     * @return boolean True if page is Demo
     */
    public function isPageFacebook()
    {
        return self::getURI( self::URI_PAGE ) == self::PAGE_FACEBOOK;
    }

    /**
     * @return boolean True if page is Demo
     */
    public function isPageDemo()
    {
        return self::getURI( self::URI_PAGE ) == self::PAGE_DEMO;
    }

    /**
     * @return boolean True if page is Logout
     */
    public function isPageLogout()
    {
        return self::getURI( self::URI_PAGE ) == self::PAGE_LOGOUT;
    }

    /**
     * @see InterfaceController::isLoginForce()
     */
    public function isLoginForce()
    {
        return false;
    }

    /**
     * @see LoginInterface::isGoogleLoggedIn()
     */
    public function isLoggedIn()
    {
        return $this->getLoginHandler()->isLoggedIn();
    }

    // ... /IS


    /**
     * @see AbstractController::request()
     */
    public function request()
    {
        if ( $this->isPageGoogle() )
        {
            $this->getLoginHandler()->doGoogleLogin( $this->getQueryCodeGoogle() );
            return self::redirect( Resource::url()->budget()->getBudget( $this->getMode( true ) ) );
        }
        else if ( $this->isPageFacebook() )
        {
            $this->getLoginHandler()->doFacebookLogin();
            return self::redirect( Resource::url()->budget()->getBudget( $this->getMode( true ) ) );
        }
        else if ( $this->isPageDemo() )
        {
            $this->getLoginHandler()->doDemoLogin();
            return self::redirect( Resource::url()->budget()->getBudget( $this->getMode( true ) ) );
        }
        elseif ( $this->isPageLogout() )
        {
            $this->getLoginHandler()->doLogout();
            self::redirect( Resource::url()->login()->getLoginPage() );
        }
    }

    // /FUNCTIONS


}

?>