<?php

namespace BattleRattle\Tests\Doorman\CodeGeneration;

use BattleRattle\Doorman\CodeGeneration\TimeBasedCodeGenerator;

class TimeBasedCodeGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideRfcSha1
     */
    public function testRfc6238ComplianceWithSha1($unixTimestamp, $code)
    {
        $generator = new TimeBasedCodeGenerator('sha1');
        $key = '12345678901234567890';
        $timestamp = \DateTime::createFromFormat('U', $unixTimestamp);

        $this->assertEquals($code, $generator->generateCode($key, 8, $timestamp));
    }

    /**
     * @dataProvider provideRfcSha256
     */
    public function testRfc6238ComplianceWithSha256($unixTimestamp, $code)
    {
        $generator = new TimeBasedCodeGenerator('sha256');
        $key = '12345678901234567890123456789012';
        $timestamp = \DateTime::createFromFormat('U', $unixTimestamp);

        $this->assertEquals($code, $generator->generateCode($key, 8, $timestamp));
    }

    /**
     * @dataProvider provideRfcSha512
     */
    public function testRfc6238ComplianceWithSha512($unixTimestamp, $code)
    {
        $generator = new TimeBasedCodeGenerator('sha512');
        $key = '1234567890123456789012345678901234567890123456789012345678901234';
        $timestamp = \DateTime::createFromFormat('U', $unixTimestamp);

        $this->assertEquals($code, $generator->generateCode($key, 8, $timestamp));
    }

    /**
     * RFC 6238 test data for SHA1
     */
    public function provideRfcSha1()
    {
        return array(
            array(59,          '94287082'),
            array(1111111109,  '07081804'),
            array(1111111111,  '14050471'),
            array(1234567890,  '89005924'),
            array(2000000000,  '69279037'),
            array(20000000000, '65353130'),
        );
    }

    /**
     * RFC 6238 test data for SHA256
     */
    public function provideRfcSha256()
    {
        return array(
            array(59,          '46119246'),
            array(1111111109,  '68084774'),
            array(1111111111,  '67062674'),
            array(1234567890,  '91819424'),
            array(2000000000,  '90698825'),
            array(20000000000, '77737706'),
        );
    }

    /**
     * RFC 6238 test data for SHA512
     */
    public function provideRfcSha512()
    {
        return array(
            array(59,          '90693936'),
            array(1111111109,  '25091201'),
            array(1111111111,  '99943326'),
            array(1234567890,  '93441116'),
            array(2000000000,  '38618901'),
            array(20000000000, '47863826'),
        );
    }
}
