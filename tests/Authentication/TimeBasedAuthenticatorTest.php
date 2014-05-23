<?php

/*
 * This file is part of the Doorman package.
 *
 * (c) Norman Soetbeer <norman.soetbeer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BattleRattle\Tests\Doorman\Authentication;

use BattleRattle\Doorman\Authentication\TimeBasedAuthenticator;

class TimeBasedAuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    private $generator;
    private $now;

    public function setUp()
    {
        $this->generator = $this->getmock('BattleRattle\\Doorman\\CodeGeneration\\TotpGeneratorInterface');
        $this->generator->expects($this->any())
            ->method('getTimeStep')
            ->with()
            ->will($this->returnValue(30));

        $this->now = \DateTime::createFromFormat('U', 1234567890);
    }

    public function testSuccessfulAuthenticationWithoutTolerance()
    {
        $this->generator
            ->expects($this->once())
            ->method('generateCode')
            ->with('fookey', 7, $this->now)
            ->will($this->returnValue('barcode'));

        $authenticator = new TimeBasedAuthenticator(0, $this->generator);
        $this->assertTrue($authenticator->authenticate('fookey', 'barcode', $this->now));
    }

    public function testFailedAuthenticationWithoutTolerance()
    {
        $this->generator
            ->expects($this->once())
            ->method('generateCode')
            ->with('fookey', 7, $this->now)
            ->will($this->returnValue('bazcode'));

        $authenticator = new TimeBasedAuthenticator(0, $this->generator);
        $this->assertFalse($authenticator->authenticate('fookey', 'barcode', $this->now));
    }

    public function testSuccessfulAuthenticationWithTolerance()
    {
        $interval = \DateInterval::createFromDateString('30 seconds');

        $this->generator
            ->expects($this->at(1))
            ->method('generateCode')
            ->with('fookey', 7, $this->isInstanceOf('DateTime'))
            ->will($this->returnValue('bazcode'));

        $this->generator
            ->expects($this->at(2))
            ->method('generateCode')
            ->with('fookey', 7, $this->isInstanceOf('DateTime'))
            ->will($this->returnValue('bazcode'));

        $this->generator
            ->expects($this->at(3))
            ->method('generateCode')
            ->with('fookey', 7, $this->isInstanceOf('DateTime'))
            ->will($this->returnValue('barcode'));

        $authenticator = new TimeBasedAuthenticator(1, $this->generator);
        $this->assertTrue($authenticator->authenticate('fookey', 'barcode', $this->now));
    }

    public function testFailedAuthenticationWithTolerance()
    {
        $this->generator
            ->expects($this->exactly(5))
            ->method('generateCode')
            ->with('fookey', 7, $this->isInstanceOf('DateTime'))
            ->will($this->returnValue('bazcode'));

        $authenticator = new TimeBasedAuthenticator(2, $this->generator);
        $this->assertFalse($authenticator->authenticate('fookey', 'barcode', $this->now));
    }
}
