<?php

namespace BattleRattle\Doorman\Util;

/**
 * Base32 Coder Decoder.
 */
class Base32Codec
{
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     * @param string $input
     * @return string
     */
    public function encode($input)
    {
        // turn input into binary sequence
        $binary = vsprintf(str_repeat('%08b', strlen($input)), unpack('C*', $input));

        // prefix each 5 bits (and the remaining ones at the end) with 3 "0"s
        $binary = preg_replace('/(.{1,5})/', '000$1', $binary);

        // pad string length to multiple of 8
        $binary = str_pad($binary, ceil(strlen($binary) / 8) * 8, '0', STR_PAD_RIGHT);

        $base32 = implode(array_map(function($byte) {
            return substr(Base32Codec::ALPHABET, bindec($byte), 1);
        }, array_filter(str_split($binary, 8))));

        // pad string length to multiple of 8 again
        return str_pad($base32, ceil(strlen($base32) / 8) * 8, '=', STR_PAD_RIGHT);
    }

    /**
     * @param string $input
     * @return string
     */
    public function decode($input)
    {
        // mapping from character to its index in the alphabet
        static $inverseAlphabet;
        if (!$inverseAlphabet) {
            $inverseAlphabet = array_flip(str_split(self::ALPHABET));
        }

        // remove all invalid characters, including possible trailing "="s
        $str = preg_replace('/[^' . preg_quote(self::ALPHABET) . ']/', '', $input);

        // create binary string
        $len = strlen($str);
        $binary = '';
        for ($i = 0; $i < $len; $i++) {
            $char = decbin($inverseAlphabet[$str[$i]]);
            $binary .= str_pad($char, 5, 0, STR_PAD_LEFT);
        }

        // cut off padded bits from the end
        $binary = substr($binary, 0, (int) (strlen($binary) / 8) * 8);

        // convert binary representation into characters
        $decoded = array_reduce(array_filter(str_split($binary, 8)), function($decoded, $byte) {
            return $decoded . chr(bindec($byte));
        }, '');

        return $decoded;
    }
}