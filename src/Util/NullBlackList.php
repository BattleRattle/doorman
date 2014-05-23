<?php

/*
 * This file is part of the Doorman package.
 *
 * (c) Norman Soetbeer <norman.soetbeer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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