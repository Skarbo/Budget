<?php

include_once '../krisskarboapi/src/util/initialize_util.php';
include_once '../krisskarboapi/src/api/api/abstract_api.php';

function __autoload( $class_name )
{
    try
    {
        $class_path = InitializeUtil::getClassPathFile( $class_name, dirname( __FILE__ ) );
        require_once ( $class_path );
    }
    catch ( Exception $e )
    {
        throw $e;
    }
}

session_start();

$client = new GoogleApi();
$client->setClientId( '605630038974.apps.googleusercontent.com' );
$client->setClientSecret( 'mUR-P95IncmZunoO45fNuKYw' );
$client->setRedirectUri( 'http://krisskarbo.com/budget/test_google.php' );
$client->setDeveloperKey( 'AIzaSyAi2eGQh6QKBcXWMpleO2rzl3p-VrLzgoE' );
$client->setApplicationName( "Personal Budget Google Test" );
// Visit https://code.google.com/apis/console?api=plus to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
// $client->setClientId('insert_your_oauth2_client_id');
// $client->setClientSecret('insert_your_oauth2_client_secret');
// $client->setRedirectUri('insert_your_redirect_uri');
// $client->setDeveloperKey('insert_your_developer_key');
$oauth2 = new Outh2ContribGoogleApi( $client );

if ( isset( $_GET[ 'code' ] ) )
{
    $client->authenticate( $_GET[ 'code' ] );
    $_SESSION[ 'token' ] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'PHP_SELF' ];
    header( 'Location: ' . filter_var( $redirect, FILTER_SANITIZE_URL ) );
    return;
}

if ( isset( $_SESSION[ 'token' ] ) )
{
    $client->setAccessToken( $_SESSION[ 'token' ] );
}

if ( isset( $_REQUEST[ 'logout' ] ) )
{
    unset( $_SESSION[ 'token' ] );
    $client->revokeToken();
}

if ( $client->getAccessToken() )
{
    $user = $oauth2->userinfo->get();

    // These fields are currently filtered through the PHP sanitize filters.
    // See http://www.php.net/manual/en/filter.filters.sanitize.php
    $email = filter_var( $user[ 'email' ], FILTER_SANITIZE_EMAIL );
    $img = filter_var( $user[ 'picture' ], FILTER_VALIDATE_URL );
    $personMarkup = "$email<div><img src='$img?sz=50'></div>";

    // The access token may have been updated lazily.
    $_SESSION[ 'token' ] = $client->getAccessToken();
}
else
{
    $authUrl = $client->createAuthUrl();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
    <header>
        <h1>Google UserInfo Sample App</h1>
    </header>
<?php if(isset($personMarkup)): ?>
<?php print $personMarkup?>
<?php endif ?>
<?php

if ( isset( $authUrl ) )
{
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
}
else
{
    print "<a class='logout' href='?logout'>Logout</a>";
  }
?>
</body>
</html>