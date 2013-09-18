<?php

namespace BattleRattle\Doorman\Util;

/**
 * A dummy blacklist, that can be used as fallback, if no other blacklist should be used.
 */
class NullBlackList implements BlackListInterface
{
    /**
     * {@inheritdoc}
     */
    public function add($key, $code)
    {
        // do nothing
    }

    /**
     * {@inheritdoc}
     */
    public function contains($key, $code)
    {
        return false;
    }
}