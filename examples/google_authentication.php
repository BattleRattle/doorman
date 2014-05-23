<?php

/*
 * This file is part of the Doorman package.
 *
 * (c) Norman Soetbeer <norman.soetbeer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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