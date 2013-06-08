<?php

abstract class MainController extends AbstractMainController implements InterfaceController
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
     * @see AbstractMainController::getTitle()
     */
    protected function getTitle()
    {
        return "Budget";
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
     * @see InterfaceController::getUser()
     */
    public function getUser()
    {
        return $this->getLoginHandler()->getUser();
    }

    protected abstract function getJavascriptView();

    protected abstract function getJavascriptController();

    protected abstract function getViewId();

    // ... /GET


    /**
     * @see AbstractController::before()
     */
    public function before()
    {
        $this->getLoginHandler()->handle();

        if ( $this->isLoginForce() && !$this->getLoginHandler()->isLoggedIn() )
        {
            self::redirect( Resource::url()->login()->getLoginPage( $this->getMode( true ) ) );
        }
    }

    /**
     * @see AbstractMainController::after()
     */
    public function after()
    {
        parent::after();

        // Add meta
        $this->addMetaTag(
                Xhtml::meta()->name( "viewport" )->content(
                        implode( ",",
                                array ( MetaXhtml::$CONTENT_VIEWPORT_WIDTH_DEVICEWIDTH,
                                        MetaXhtml::$CONTENT_VIEWPORT_INITIALSCALE_1,
                                        MetaXhtml::$CONTENT_VIEWPORT_USERSCALABLE_NO,
                                        MetaXhtml::$CONTENT_VIEWPORT_MINCALE_1, MetaXhtml::$CONTENT_VIEWPORT_MAXSCALE_1 ) ) ) );

        // Add default Javascript files
        //$this->addJavascriptFile( Resource::javascript()->getGoogleChart() );
        $this->addJavascriptFile( Resource::javascript()->getJqueryApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJqueryHistoryApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJqueryDragApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getBudgetApiFile() );

        // Add favicon
        $this->addHead( Xhtml::link()->rel( "shortcut icon" )->href( Resource::image()->icon()->getFavicon() ) );

        // Add default CSS files
        $this->addCssFile( Resource::css()->getBudgetFile() );

        // Javascript code
        $code = <<<EOD
var controller;
var view;
var eventHandler = new EventHandler();
$(document).ready(function() {
	view = new %s('%s');
  	controller = new %s(eventHandler, %d, %s);
  	controller.render(view);
} );
EOD;

        // Add Javascript code
        $this->addJavascriptCode(
                sprintf( $code, $this->getJavascriptView(), $this->getViewId(), $this->getJavascriptController(),
                        $this->getMode(), json_encode( array () ) ) );

    }

    // /FUNCTIONS


}

?>