<?php

/*
 * This file is part of the Doorman package.
 *
 * (c) Norman Soetbeer <norman.soetbeer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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