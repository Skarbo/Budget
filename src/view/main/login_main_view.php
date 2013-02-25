<?php

class LoginMainView extends MainView implements LoginInterface
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see MainView::getController()
     * @return LoginMainController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see MainView::getLastModified()
     */
    public function getLastModified()
    {
        return filemtime( __FILE__ );
    }

    /**
     * @see LoginInterface::getGoogleAuthUrl()
     */
    public function getGoogleAuthUrl()
    {
        return $this->getController()->getGoogleAuthUrl();
    }

    /**
     * @see LoginInterface::getFacebookAuthUrl()
     */
    public function getFacebookAuthUrl()
    {
        return $this->getController()->getFacebookAuthUrl();
    }

    /**
     * @see LoginInterface::getUser()
     */
    public function getUser()
    {
        return $this->getController()->getUser();
    }

    // ... /GET


    // ... IS


    /**
     * @see LoginInterface::isLoggedIn()
     */
    public function isLoggedIn()
    {
        return $this->getController()->isLoggedIn();
    }

    // ... /IS


    /**
     * @see AbstractView::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        parent::draw( $root );

        // Actionbar presenter
        $this->actionbarPresenter->setReferral( Resource::url()->budget()->getBudget( $this->getMode() ) );
        $this->actionbarPresenter->setIcon( Xhtml::div()->attr( "data-icon", "login" ) );
        $this->actionbarPresenter->setViewControl( Xhtml::div( "Login" ) );

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_BUDGET_WRAPPER );

        $this->actionbarPresenter->draw( $wrapper );

        $loginWrapper = Xhtml::div()->class_( "login_wrapper" );

        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        if ( !$this->isLoggedIn() )
        {

            // Google button
            $table->addContent(
                    Xhtml::div(
                            Xhtml::div(
                                    Xhtml::a( Xhtml::div( Xhtml::img( Resource::image()->icon()->getGoogle() ) ),
                                            $this->getGoogleAuthUrl() )->addContent( Xhtml::div( "Sign in with Google" ) )->class_(
                                            "login_button" ) ) )->class_( Resource::css()->getTableRow() ) );

            // Facebook button
            $table->addContent(
                    Xhtml::div(
                            Xhtml::div(
                                    Xhtml::a( Xhtml::div( Xhtml::img( Resource::image()->icon()->getFacebook() ) ),
                                            $this->getFacebookAuthUrl() )->addContent(
                                            Xhtml::div( "Sign in with Facebook" ) )->class_( "login_button" ) ) )->class_(
                            Resource::css()->getTableRow() ) );

            // Demo button
            $table->addContent(
                    Xhtml::div(
                            Xhtml::div(
                                    Xhtml::a( Xhtml::div( Xhtml::img( Resource::image()->icon()->getEmpty() ) ),
                                            Resource::url()->login()->getLoginDemoPage( $this->getMode() ) )->addContent(
                                            Xhtml::div( "Sign in with Demo" ) )->class_( "login_button" ) ) )->class_(
                            Resource::css()->getTableRow() ) );

        }
        else
        {
            // Logout button
            $table->addContent(
                    Xhtml::div(
                            Xhtml::div(
                                    Xhtml::a( Xhtml::div()->attr( "data-icon", "logout" ),
                                            Resource::url()->login()->getLogoutPage( $this->getMode() ) )->addContent(
                                            Xhtml::div( "Logout" ) )->class_( "login_button" ) ) )->class_(
                            Resource::css()->getTableRow() ) );
        }

        $loginWrapper->addContent( $table );

        $wrapper->addContent( $loginWrapper );
        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

?>