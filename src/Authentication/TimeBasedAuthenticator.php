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

use BattleRattle\Doorman\CodeGeneration\TimeBasedCodeGenerator;
use BattleRattle\Doorman\CodeGeneration\TotpGeneratorInterface;
use BattleRattle\Doorman\Util\BlackListInterface;
use BattleRattle\Doorman\Util\NullBlackList;

/**
 * Basic authenticator for TOTP.
 */
class TimeBasedAuthenticator implements AuthenticatorInterface
{
    /** @var int */
    private $lookAround;
    /** @var TotpGeneratorInterface */
    private $generator;
    /** @var BlackListInterface */
    private $blacklist;

    /**
     * @param int $lookAround The tolerance of acceptable time frames.
     * @param TotpGeneratorInterface $generator The code generator for TOTP algorithm.
     * @param BlackListInterface $blacklist A blacklist for blocked keys and codes.
     * @throws \InvalidArgumentException
     */
    public function __construct($lookAround = 1, TotpGeneratorInterface $generator = null, BlackListInterface $blacklist = null)
    {
        if ($lookAround < 0) {
            throw new \InvalidArgumentException('Lookaround must not be negative');
        }

        $this->lookAround = (int) $lookAround;
        $this->generator = $generator ?: new TimeBasedCodeGenerator();
        $this->blacklist = $blacklist ?: new NullBlackList();
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($key, $code, \DateTime $timestampToCheck = null)
    {
        $timestampToCheck = $timestampToCheck ?: new \DateTime();

        if ($this->blacklist->contains($key, $code)) {
            return false;
        }

        $timeStep = $this->generator->getTimeStep();
        $lookAroundSeconds = (int) ($this->lookAround * $timeStep);
        $interval = \DateInterval::createFromDateString($lookAroundSeconds . ' seconds');

        $start = clone $timestampToCheck;
        $start->sub($interval);

        $end = clone $timestampToCheck;
        $end->add($interval);

        $modification = '+ ' . $timeStep . ' seconds';

        for ($timestamp = $start; $timestamp <= $end; $timestamp->modify($modification)) {
            $generatedCode = $this->generator->generateCode($key, strlen($code), $timestamp);

            if ($generatedCode === $code) {
                $this->blacklist->add($key, $code);
                return true;
            }

            if (!$this->lookAround) {
                break;
            }
        }

        $this->blacklist->add($key, $code);
        return false;
    }
}