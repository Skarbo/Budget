<?php

abstract class MainView extends AbstractMainView
{

    // VARIABLES

    public static $ID_BUDGET_WRAPPER = "budget_wrapper";

    /**
     * @var ActionbarPresenterView
     */
    protected $actionbarPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractView::getController()
     * @return MainController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see AbstractView::getLastModified()
     */
    public function getLastModified()
    {
        return filemtime( __FILE__ );
    }

    // ... /GET


    public function before()
    {
        parent::before();

        $this->actionbarPresenter = new ActionbarPresenterView( $this );
    }

    // /FUNCTIONS


}

?>