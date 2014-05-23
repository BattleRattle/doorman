<?php

/*
 * This file is part of the Doorman package.
 *
 * (c) Norman Soetbeer <norman.soetbeer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BattleRattle\Doorman\CodeGeneration;

use BattleRattle\Doorman\Util\Base32Codec;

/**
 * Code generator, that is compliant to Google Authenticator.
 *
 * In order to be compliant the GA the algorithm (sha1), reference time (0) and time step (30) are enforced here.
 * Additionally the key must be base32-encoded and should have a length of 16 characters.
 */
class GoogleAuthCodeGenerator extends TimeBasedCodeGenerator
{
    /** @var Base32Codec */
    private $base32encoder;

    /**
     * @param Base32Codec $base32encoder
     */
    public function __construct(Base32Codec $base32encoder = null)
    {
        parent::__construct();

        $this->base32encoder = $base32encoder ?: new Base32Codec();
    }

    /**
     * {@inherited}
     */
    public function generateCode($key, $length = 6, \DateTime $timestamp = null)
    {
        $decodedKey = $this->base32encoder->decode($key);

        return parent::generateCode($decodedKey, $length, $timestamp);
    }
}