<?php

/*
 * This file is part of the Doorman package.
 *
 * (c) Norman Soetbeer <norman.soetbeer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BattleRattle\Tests\Doorman\Util;

use BattleRattle\Doorman\Util\Base32Codec;

class Base32CodecTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider proviceRfc4648TestData
     */
    public function testEncode($raw, $encoded)
    {
        $encoder = new Base32Codec();

        $this->assertEquals($encoded, $encoder->encode($raw));
    }

    /**
     * @dataProvider proviceRfc4648TestData
     */
    public function testDecode($raw, $encoded)
    {
        $decoder = new Base32Codec();

        $this->assertEquals($raw, $decoder->decode($encoded));
    }

    /**
     * Example test cases as provided by RFC-4648
     *
     * @see http://www.ietf.org/rfc/rfc4648.txt
     */
    public function proviceRfc4648TestData()
    {
        return array(
            array('',       ''),
            array('f',      'MY======'),
            array('fo',     'MZXQ===='),
            array('foo',    'MZXW6==='),
            array('foob',   'MZXW6YQ='),
            array('fooba',  'MZXW6YTB'),
            array('foobar', 'MZXW6YTBOI======'),
        );
    }
}
