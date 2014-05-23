Doorman
=======

Build status: [![Build Status](https://travis-ci.org/BattleRattle/doorman.png?branch=master)](https://travis-ci.org/BattleRattle/doorman)

Doorman is an RFC-compliant implementation of the TOTP (Time-Based One-Time Passsword, [RFC 6238](https://www.ietf.org/rfc/rfc6238.txt))
algorithm, which is commonly used for Two Factor Authentication.

A wrapper for the [Google Authenticator](https://support.google.com/accounts/answer/1066447) - a key manager and code generator,
which can be downloaded for free, is also available. It also works for other
3rd party code generators, that use the TOTP algorithm.

Requirements
------------

You need at least a **64-bit** version of PHP 5.4 or HHVM.

Installation via Composer
-------------------------

Use Composer CLI:

```
php composer.phar require battlerattle/doorman:1.0.*@dev
```

Or add `battlerattle/doorman` to your `composer.json`:

```
"require": {
    "battlerattle/doorman": "1.0.*@dev"
},
```

Usage
-----

This is a pretty basic example

```php
use BattleRattle\Doorman\Authentication\TimeBasedAuthenticator;

// get the code from user input
$code = '...';

// the user's secret key
$key = '...';

$authenticator = new TimeBasedAuthenticator();
$result = $authenticator->authenticate($key, $code);

if ($result) {
    echo 'Welcome, you successfully logged in';
} else {
    echo 'Nope, please try again';
}
```

Google Authenticator
--------------------

In this example we use the Google Authenticator, which uses base32-encoded keys, that will be decoded internally.

```php
use BattleRattle\Doorman\Authentication\GoogleAuthenticator;

$code = '...';
$key = '...';

$authenticator = new GoogleAuthenticator();
$result = $authenticator->authenticate($key, $code);

if ($result) {
    echo 'Welcome, you successfully logged in';
} else {
    echo 'Nope, please try again';
}
```

Key Generator
-------------

This generator creates "Google Authenticator"-compliant keys:

```php
use BattleRattle\Doorman\KeyGeneration\GoogleAuthKeyGenerator;

$keyGenerator = new GoogleAuthKeyGenerator;
$key = $keyGenerator->generateKey();

// it's good practice to split the key into chunks of 4 characters for better readability
$formattedKey = implode(' ', str_split($key, 4));

echo 'Add this key to your authenticator: ' . $formattedKey;
```

References
----------

* [Better Security with Two Factor Authentication](http://www.slideshare.net/battlerattle/better-security-with-two-factor-authentication-php-unconference-2013) - presentation about functionality of Two Factor Authentication
* [RFC 6238](https://www.ietf.org/rfc/rfc6238.txt) - official description of the "Time-Based One-Time Password" algorithm
* [Google Authenticator](https://support.google.com/accounts/answer/1066447) - authenticator for Android / iPhone / BlackBerry
* [Duo Mobile](http://guide.duosecurity.com/third-party-accounts) - authenticator for Android / iPhone