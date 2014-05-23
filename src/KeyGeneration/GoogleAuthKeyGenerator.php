<?php

/*
 * This file is part of the Doorman package.
 *
 * (c) Norman Soetbeer <norman.soetbeer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BattleRattle\Doorman\KeyGeneration;

class GoogleAuthKeyGenerator implements KeyGeneratorInterface
{
    const KEY_LENGTH = 16;
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     * @return string
     */
    public function generateKey()
    {
        $key = '';
        $alphabetLength = strlen(self::ALPHABET);

        for ($i = 0; $i < self::KEY_LENGTH; $i++) {
            $key .= substr(self::ALPHABET, mt_rand(0, $alphabetLength - 1), 1);
        }

        return $key;
    }
}