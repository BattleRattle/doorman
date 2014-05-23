<?php

namespace BattleRattle\Doorman\Authentication;

interface AuthenticatorInterface
{
    /**
     * Authenticate by a given code and a key.
     *
     * @param string $key The secret key.
     * @param string $code The code to check against.
     * @return boolean
     */
    public function authenticate($key, $code);
}