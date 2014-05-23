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

/**
 * Time-Based code generator (TOTP algorithm).
 */
class TimeBasedCodeGenerator implements TotpGeneratorInterface
{
    private $algorithm;
    private $referenceTimestamp;
    private $timeStep;

    /**
     * @param string $algorithm
     * @param int $referenceTimestamp
     * @param int $timeStep
     * @throws \InvalidArgumentException
     */
    public function __construct($algorithm = 'sha1', $referenceTimestamp = 0, $timeStep = 30)
    {
        if (!in_array($algorithm, hash_algos())) {
            throw new \InvalidArgumentException('Hash algorithm is not supported by your PHP installation: ' . $algorithm);
        }

        if (!in_array(strtolower($algorithm), array('sha1', 'sha256', 'sha512'))) {
            throw new \InvalidArgumentException('This generator does not support the chosen hash algorithm: ' . $algorithm);
        }

        if ($timeStep < 1) {
            throw new \InvalidArgumentException('Time step must be greater than or equal to 1');
        }

        $this->algorithm = $algorithm;
        $this->referenceTimestamp = $referenceTimestamp;
        $this->timeStep = $timeStep;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeStep()
    {
        return $this->timeStep;
    }

    /**
     * {@inheritdoc}
     */
    public function generateCode($key, $length = 6, \DateTime $timestamp = null)
    {
        $timestamp = $timestamp ?: new \DateTime();
        $movingFactor = (int) (($timestamp->getTimestamp() - $this->referenceTimestamp) / $this->timeStep);

        $hash = hash_hmac($this->algorithm, $this->packFactor($movingFactor), $key, true);
        $truncated = $this->truncate($hash, $length);

        return $truncated;
    }

    /**
     * @param string $factor
     * @return string
     */
    private function packFactor($factor)
    {
        return pack('C8',
            ($factor >> 56) & 0xFF, ($factor >> 48) & 0xFF,
            ($factor >> 40) & 0xFF, ($factor >> 32) & 0xFF,
            ($factor >> 24) & 0xFF, ($factor >> 16) & 0xFF,
            ($factor >>  8) & 0xFF, ($factor >>  0) & 0xFF);
    }

    /**
     * @param string $value
     * @param int $digits
     * @return string
     */
    private function truncate($value, $digits)
    {
        $bytes = unpack('C*', $value);
        $offset = end($bytes) & 0xf;

        // remember: unpack()'s offset begins with 1!
        $bytesValue = (($bytes[$offset + 1] & 0x7F) << 24) | ($bytes[$offset + 2] << 16)
            | ($bytes[$offset + 3] << 8) | ($bytes[$offset + 4]);

        return str_pad(substr($bytesValue, -$digits), $digits, '0', STR_PAD_LEFT);
    }
}