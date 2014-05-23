<?php

namespace BattleRattle\Doorman\Authentication;

use BattleRattle\Doorman\Util\BlackListInterface;
use BattleRattle\Doorman\CodeGeneration\GoogleAuthCodeGenerator;

/**
 * Authentication wrapper, that is compliant to the Google Authenticator, with blacklist support for better security.
 */
class GoogleAuthenticator extends TimeBasedAuthenticator
{
    /** Reference UNIX timestamp */
    const REFERENCE_TIME = 0;
    /** Time frame length in seconds */
    const TIME_STEP = 30;

    /**
     * @param int $lookAround The tolerance of acceptable time frames.
     * @param GoogleAuthCodeGenerator $generator The code generator for TOTP algorithm.
     * @param BlackListInterface $blacklist A blacklist for blocked keys and codes.
     * @throws \InvalidArgumentException
     */
    public function __construct($lookAround = 1, GoogleAuthCodeGenerator $generator = null, BlackListInterface $blacklist = null)
    {
        $generator = $generator ?: new GoogleAuthCodeGenerator();

        parent::__construct($lookAround, $generator, $blacklist);
    }
}