<?php

class LoginHandler extends Handler
{

    // VARIABLES


    public static $SESSION_LOGGEDIN = "loggedin";
    public static $SESSION_GOOGLE = "google_token";
    public static $SESSION_DEMO = "demo_token";

    /**
     * @var DaoContainer
     */
    private $daoContainer;
    /**
     * @var GoogleApi
     */
    private $googleApi;
    /**
     * @var FacebookApi
     */
    private $facebookApi;
    /**
     * @var Outh2ContribGoogleApi
     */
    private $oauth2;

    /**
     * @var UserModel
     */
    private $user;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DaoContainer $daoContainer, $mode )
    {
        $this->daoContainer = $daoContainer;

        // Google
        $this->googleApi = new GoogleApi();
        $this->googleApi->setClientId( BudgetApi::$GOOGLE_CLIENT_ID );
        $this->googleApi->setClientSecret( BudgetApi::$GOOGLE_CLIENT_SECRET );
        $this->googleApi->setRedirectUri(
                UrlResource::getFullUrl( Resource::url()->login()->getLoginGooglePage( $mode ) ) );
        $this->googleApi->setDeveloperKey( BudgetApi::$GOOGLE_DEVELOPER_KEY );
        $this->googleApi->setApplicationName( "Personal Budget" );

        $this->oauth2 = new Outh2ContribGoogleApi( $this->googleApi );

        // Facebook
        $this->facebookApi = new FacebookApi(
                array ( 'appId' => BudgetApi::$FACEBOOK_API_ID, 'secret' => BudgetApi::$FACEBOOK_API_SECRET,
                        'redirectUrl' => UrlResource::getFullUrl(
                                Resource::url()->login()->getLoginFacebookPage( $mode ) ) ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return UserModel
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return GoogleApi
     */
    public function getGoogleApi()
    {
        return $this->googleApi;
    }

    /**
     * @return FacebookApi
     */
    public function getFacebookApi()
    {
        return $this->facebookApi;
    }

    /**
     * @return Google_Userinfo
     */
    private function getUserGoogle()
    {
        if ( $this->isLoggedInGoogle() )
            return $this->oauth2->userinfo->get();
        return null;
    }

    /**
     * @return array|NULL Array(id, name, email, ...)|NULL
     */
    private function getUserFacebook()
    {
        if ( $this->isLoggedInFacebook() )
        {
            try
            {
                return $this->getFacebookApi()->api( '/me' );
            }
            catch ( FacebookApiException $e )
            {
                return null;
            }
        }
        return null;
    }

    // ... /GET


    // ... IS


    /**
     * @return boolean True if logged in
     */
    public function isLoggedIn()
    {
        return $this->getUser() != null;
    }

    /**
     * @return boolean True if logged in with Google
     */
    private function isLoggedInGoogle()
    {
        return $this->googleApi->getAccessToken() != null;
    }

    /**
     * @return boolean True if logged in with Facebook
     */
    private function isLoggedInFacebook()
    {
        return $this->facebookApi->getUser() != 0;
    }

    /**
     * @return boolean True if logged in with Demo
     */
    private function isLoggedInDemo()
    {
        return isset( $_SESSION[ self::$SESSION_DEMO ] ) || isset( $_COOKIE[ self::$SESSION_DEMO ] );
    }

    // ... /IS


    // ... DO


    // ... ... LOGIN


    /**
     * Redirect after login
     *
     * @param string $code
     */
    public function doGoogleLogin( $code )
    {
        $this->googleApi->authenticate( $code );
        $_SESSION[ self::$SESSION_GOOGLE ] = $this->googleApi->getAccessToken();

        $userGoogle = $this->getUserGoogle();
        if ( $userGoogle )
        {
            $authUser = $this->daoContainer->getAuthUserDao()->getUser( $userGoogle->getId(),
                    AuthUserModel::AUTH_TYPE_GOOGLE );

            if ( !$authUser )
            {
                $authUser = $this->doRegisterGoogle( $userGoogle );
            }
            $this->doLoginAuthUser( $authUser );
        }
    }

    public function doDemoLogin()
    {
        $_SESSION[ self::$SESSION_DEMO ] = true;
        $_COOKIE[ self::$SESSION_DEMO ] = true;

        $authUser = $this->daoContainer->getAuthUserDao()->getUser( AuthUserModel::AUTH_TYPE_DEMO,
                AuthUserModel::AUTH_TYPE_DEMO );

        if ( !$authUser )
        {
            $authUser = $this->doRegisterDemo();
        }
        $this->doLoginAuthUser( $authUser );
    }

    public function doFacebookLogin()
    {
        $userProfile = $this->getUserFacebook();
        if ( $userProfile )
        {
            $authUser = $this->daoContainer->getAuthUserDao()->getUser( Core::arrayAt( $userProfile, "id" ),
                    AuthUserModel::AUTH_TYPE_FACEBOOK );

            if ( !$authUser )
            {
                $authUser = $this->doRegisterFacebook( $userProfile );
            }
            $this->doLoginAuthUser( $authUser );
        }
    }

    private function doLoginAuthUser( AuthUserModel $authUser )
    {
        if ( $authUser )
        {
            $this->daoContainer->getAuthUserDao()->setLoggedin( $authUser->getUserId(), $authUser->getUserAuthType() );
            $this->doLogin( $authUser->getUserId() );
        }
        else
        {
            $this->doLogout();
        }
    }

    private function doLogin( $userId )
    {
        $this->user = UserModel::get_( $this->daoContainer->getUserDao()->get( $userId ) );

        if ( $userId )
        {
            $this->daoContainer->getUserDao()->setLoggedin( $this->user->getId() );
            $_SESSION[ self::$SESSION_LOGGEDIN ] = $this->user->getId();
            $_COOKIE[ self::$SESSION_LOGGEDIN ] = $this->user->getId();
        }
        else
        {
            $this->doLogout();
        }
    }

    // ... ... /LOGIN


    // ... ... LOGOUT


    private function doGoogleLogout()
    {
        unset( $_SESSION[ self::$SESSION_GOOGLE ] );
        $this->googleApi->revokeToken();
    }

    private function doDemoLogout()
    {
        unset( $_SESSION[ self::$SESSION_DEMO ] );
    }

    public function doLogout()
    {
        $this->doGoogleLogout();
        $this->doDemoLogout();
        unset( $_SESSION[ self::$SESSION_LOGGEDIN ] );
        unset( $_COOKIE[ self::$SESSION_LOGGEDIN ] );
        $this->user = null;
    }
    // ... ... /LOGOUT


    private function doRegisterUser( $id, $name, $email, $type )
    {
        $user = UserFactoryModel::createUser( $name, $email );
        $user->setId( $this->daoContainer->getUserDao()->add( $user, null ) );

        $authUser = AuthUserFactoryModel::createAuthUser( $id, $user->getId(), $type );
        $this->daoContainer->getAuthUserDao()->add( $authUser, $user->getId() );

        $this->doRegisterBudget( $user->getId() );

        return $this->daoContainer->getAuthUserDao()->getUser( $authUser->getId(), $type );
    }

    /**
     * @param Google_Userinfo $userGoogle
     * @return AuthUserModel
     */
    private function doRegisterGoogle( Google_Userinfo $userGoogle )
    {
        return $this->doRegisterUser( $userGoogle->getId(), $userGoogle->getName(), $userGoogle->getEmail(),
                AuthUserModel::AUTH_TYPE_GOOGLE );
    }

    /**
     * @return AuthUserModel
     */
    private function doRegisterDemo()
    {
        return $this->doRegisterUser( AuthUserModel::AUTH_TYPE_DEMO, "Demo", "demo@email.com",
                AuthUserModel::AUTH_TYPE_DEMO );
    }

    /**
     * @return AuthUserModel
     */
    private function doRegisterFacebook( array $userFacebook )
    {
        return $this->doRegisterUser( Core::arrayAt( $userFacebook, "id" ), Core::arrayAt( $userFacebook, "name" ),
                Core::arrayAt( $userFacebook, "email" ), AuthUserModel::AUTH_TYPE_FACEBOOK );
    }

    private function doRegisterBudget( $userId )
    {
        $budget = BudgetFactoryModel::createBudget( "Personal Budget" );
        $budget->setId( $this->daoContainer->getBudgetDao()->add( $budget, null ) );
        $this->daoContainer->getBudgetDao()->addUser( $budget->getId(), $userId );
        $this->daoContainer->getBudgetDao()->mergeUser();
    }

    // ... /DO


    public function handle()
    {
        session_start();
        session_regenerate_id();

        //         // GOOGLE


        //         // Set Google token
        //         if ( isset( $_SESSION[ self::$SESSION_GOOGLE ] ) )
        //         {
        //             $this->googleApi->setAccessToken( $_SESSION[ self::$SESSION_GOOGLE ] );
        //         }


        //         // Reset access token
        //         if ( $this->googleApi->getAccessToken() )
        //         {
        //             $_SESSION[ self::$SESSION_GOOGLE ] = $this->googleApi->getAccessToken();
        //         }


        //         // /GOOGLE


        $userId = Core::arrayAt( $_SESSION, self::$SESSION_LOGGEDIN );
        if ( !$userId )
            $userId = Core::arrayAt( $_COOKIE, self::$SESSION_LOGGEDIN );
        $this->doLogin( $userId );

    }

    // /FUNCTIONS


}

?>