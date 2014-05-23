<?php

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