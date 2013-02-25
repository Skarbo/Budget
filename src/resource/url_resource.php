<?php

class UrlResource extends AbstractUrlResource
{

    // VARIABLES


    private static $FILE = "";
    private static $BUDGET, $LOGIN;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... CONTROLLER


    public static function getController( $controller, $mode = null, $url = "" )
    {
        return UrlResource::getUrl( self::$FILE, $mode, sprintf( "/%s%s", $controller, $url ) );
    }

    // ... /CONTROLLER


    // ... PAGE


    public static function getPage( $controller, $page, $mode = null, $url = "" )
    {
        return self::getController( $controller, $mode, sprintf( "/%s%s", $page, $url ) );
    }

    // ... /PAGE


    /**
     * @return BudgetUrlResource
     */
    public function budget()
    {
        self::$BUDGET = self::$BUDGET ? self::$BUDGET : new BudgetUrlResource();
        return self::$BUDGET;
    }

    /**
     * @return LoginUrlResource
     */
    public function login()
    {
        self::$LOGIN = self::$LOGIN ? self::$LOGIN : new LoginUrlResource();
        return self::$LOGIN;
    }

    // /FUNCTIONS


}

?>