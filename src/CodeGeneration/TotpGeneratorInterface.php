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

interface TotpGeneratorInterface
{
    /**
     * Generate a TOTP-compliant code.
     *
     * @param string $key
     * @param int $length
     * @param \DateTime $timestamp
     * @return string
     */
    public function generateCode($key, $length = 6, \DateTime $timestamp = null);

    /**
     * Get the configured time step in seconds.
     *
     * @return int
     */
    public function getTimeStep();
}