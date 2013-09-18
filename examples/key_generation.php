<?php

/**
 * This example shows, how you can generate a new key for a user.
 * It is compliant with Google Authenticator.
 */

require '../vendor/autoload.php';

use BattleRattle\Doorman\KeyGeneration\GoogleAuthKeyGenerator;

// create an instance of the key generator and simply create new random key
$keyGenerator = new GoogleAuthKeyGenerator;
$key = $keyGenerator->generateKey();

// it's good practice to split the key into chunks of 4 characters for better readability
$formattedKey = implode(' ', str_split($key, 4));

echo 'Add this key to your authenticator: ' . $formattedKey;

// Example output:
// Add this key to your authenticator: U2IK DLVF EC62 7YTS

// of course, you need to save this key in a persistent storage and associate it with the user in order to use it for authentication later