<?php

/**
 * This example shows, how you can authenticate a user, using the Google compliant authentication.
 */

require '../vendor/autoload.php';

use BattleRattle\Doorman\Authentication\GoogleAuthenticator;

// get the code from user input
// since this is just a basic example, we directly access $_POST
$code = $_POST['code'];

// get the associated key for the current user, you probably want to read this from a persistent storage
$key = 'ONETIMEPASSWORDS';

$authenticator = new GoogleAuthenticator();
$result = $authenticator->authenticate($key, $code);

if ($result) {
    echo 'Welcome, you successfully logged in';
} else {
    echo 'Nope, please try again';
}