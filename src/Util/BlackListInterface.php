<?php

namespace BattleRattle\Doorman\Util;

/**
 * Simple interface for a blacklist, that manages blocked codes.
 */
interface BlackListInterface
{
    /**
     * Add the combination of key and code to the blacklist.
     *
     * @param string $key The key.
     * @param string $code The code.
     * @return void
     */
    public function add($key, $code);

    /**
     * Check, if blacklist contains the combination of key and code.
     *
     * @param string $key The key.
     * @param string $code The code.
     * @return boolean
     */
    public function contains($key, $code);
}