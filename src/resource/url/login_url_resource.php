<?php

class LoginUrlResource extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getController( $mode = null, $url = "" )
    {
        return UrlResource::getController( LoginMainController::$CONTROLLER_NAME, $mode, $url );
    }

    public static function getPage( $page, $mode = null, $url = "" )
    {
        return self::getController( $mode, sprintf( "/%s%s", $page, $url ) );
    }

    public function getLoginPage( $mode = null, $url = "" )
    {
        return self::getPage( LoginMainController::PAGE_LOGIN, $mode, $url );
    }

    public function getLogoutPage( $mode = null, $url = "" )
    {
        return self::getPage( LoginMainController::PAGE_LOGOUT, $mode, $url );
    }

    public function getLoginDemoPage( $mode = null, $url = "" )
    {
        return self::getPage( LoginMainController::PAGE_DEMO, $mode, $url );
    }

    public function getLoginGooglePage( $mode = null, $url = "" )
    {
        return self::getPage( LoginMainController::PAGE_GOOGLE, $mode, $url );
    }

    public function getLoginFacebookPage( $mode = null, $url = "" )
    {
        return self::getPage( LoginMainController::PAGE_FACEBOOK, $mode, $url );
    }

    // /FUNCTIONS


}

?>