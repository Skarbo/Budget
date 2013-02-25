<?php

class BudgetMainController extends MainController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "budget";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see MainController::getJavascriptController()
     */
    protected function getJavascriptController()
    {
        return "BudgetMainController";
    }

    /**
     * @see MainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "BudgetMainView";
    }

    /**
     * @see MainController::getViewId()
     */
    protected function getViewId()
    {
        return BudgetMainView::$ID_BUDGET_WRAPPER;
    }

    // ... /GET


    // ... IS


    /**
     * @see InterfaceController::isLoginForce()
     */
    public function isLoginForce()
    {
        return true;
    }

    // ... /IS


    /**
     * @see AbstractController::request()
     */
    public function request()
    {

    }

    // /FUNCTIONS


}

?>