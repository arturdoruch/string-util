<?php

namespace ArturDoruch\StringUtil;

/**
 * Character sets utilities.
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class CharsetUtils
{
    /**
     * Checks whether a string has UTF-8 encoding type.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function isUtf8(string $string): bool
    {
        return preg_match('//u', $string); //(bool) mb_detect_encoding($string, 'UTF-8', $strict = true);
    }

    /**
     * Removes characters not available in the UTF-8 encoding type.
     * Code taken from https://webcollab.sourceforge.io/unicode.html
     *
     * @param string $string
     *
     * @return string
     */
    public static function cleanupUtf8(string $string): string
    {
        return preg_replace(
            '/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
            '|[\x00-\x7F][\x80-\xBF]+'.
            '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
            '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
            '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
            '', $string);
    }

    /**
     * Decodes hexadecimal code points of the UTF-8 charset escaped with "\u", like "\uXXXX".
     * The code points of the characters not available in the UTF-8 charset are removed.
     * Code taken from https://stackoverflow.com/a/2934602
     *
     * @param string $string
     * @param string $encoding Encoding type of the $string. E.g: UTF-16BE.
     *
     * @return string
     */
    public static function decodeHexCodePoints(string $string, string $encoding = 'UCS-2BE'): string
    {
        return preg_replace_callback('/\\\u([0-9a-fA-F]{4,6})/', function ($matches) use ($encoding) {
            if (strlen($matches[1]) > 4) {
                return '';
            }

            return mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', $encoding);
        }, $string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function decodeNonBreakingSpaces($string): string
    {
        $string = str_replace('&nbsp;', ' ', $string);

        if (null === $str = preg_replace('/\x{00A0}/u', ' ', $string)) {
            return $string;
        }

        return $str;
    }

    /**
     * Removes accents (diacritic marks) from a string, by converting them to their
     * corresponding non-accented ASCII characters.
     *
     * @param string $string
     *
     * @return string
     */
    public static function removeAccents(string $string): string
    {
        return strtr($string, self::ACCENTED_CHARACTERS);
    }

    const ACCENTED_CHARACTERS = [
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'A',
        '??' => 'Ae',
        '??' => 'Ae',
        '??' => 'Aa',
        '??' => 'a',
        '??' => 'C',
        '??' => 'E',
        '??' => 'E',
        '??' => 'E',
        '??' => 'E',
        '??' => 'I',
        '??' => 'I',
        '??' => 'I',
        '??' => 'I',
        '??' => 'N',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'O',
        '??' => 'Oe',
        '??' => 'U',
        '??' => 'U',
        '??' => 'U',
        '??' => 'Ue',
        '??' => 'Y',
        '??' => 'ss',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'a',
        '??' => 'ae',
        '??' => 'aa',
        '??' => 'c',
        '??' => 'e',
        '??' => 'e',
        '??' => 'e',
        '??' => 'e',
        '??' => 'i',
        '??' => 'i',
        '??' => 'i',
        '??' => 'i',
        '??' => 'n',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'o',
        '??' => 'oe',
        '??' => 'u',
        '??' => 'u',
        '??' => 'u',
        '??' => 'ue',
        '??' => 'y',
        '??' => 'y',
        '??' => 'A',
        '??' => 'a',
        '??' => 'A',
        '??' => 'a',
        '??' => 'A',
        '??' => 'a',
        '??' => 'C',
        '??' => 'c',
        '??' => 'C',
        '??' => 'c',
        '??' => 'C',
        '??' => 'c',
        '??' => 'C',
        '??' => 'c',
        '??' => 'D',
        '??' => 'd',
        '??' => 'D',
        '??' => 'd',
        '??' => 'E',
        '??' => 'e',
        '??' => 'E',
        '??' => 'e',
        '??' => 'E',
        '??' => 'e',
        '??' => 'E',
        '??' => 'e',
        '??' => 'E',
        '??' => 'e',
        '??' => 'G',
        '??' => 'g',
        '??' => 'G',
        '??' => 'g',
        '??' => 'G',
        '??' => 'g',
        '??' => 'G',
        '??' => 'g',
        '??' => 'H',
        '??' => 'h',
        '??' => 'H',
        '??' => 'h',
        '??' => 'I',
        '??' => 'i',
        '??' => 'I',
        '??' => 'i',
        '??' => 'I',
        '??' => 'i',
        '??' => 'I',
        '??' => 'i',
        '??' => 'I',
        '??' => 'i',
        '??' => 'IJ',
        '??' => 'ij',
        '??' => 'J',
        '??' => 'j',
        '??' => 'K',
        '??' => 'k',
        '??' => 'k',
        '??' => 'L',
        '??' => 'l',
        '??' => 'L',
        '??' => 'l',
        '??' => 'L',
        '??' => 'l',
        '??' => 'L',
        '??' => 'l',
        '??' => 'L',
        '??' => 'l',
        '??' => 'N',
        '??' => 'n',
        '??' => 'N',
        '??' => 'n',
        '??' => 'N',
        '??' => 'n',
        '??' => 'N',
        '??' => 'n',
        '??' => 'N',
        '??' => 'O',
        '??' => 'o',
        '??' => 'O',
        '??' => 'o',
        '??' => 'O',
        '??' => 'o',
        '??' => 'OE',
        '??' => 'oe',
        '??' => 'O',
        '??' => 'o',
        '??' => 'R',
        '??' => 'r',
        '??' => 'R',
        '??' => 'r',
        '??' => 'R',
        '??' => 'r',
        '??' => 'S',
        '??' => 's',
        '??' => 'S',
        '??' => 's',
        '??' => 'S',
        '??' => 's',
        '??' => 'S',
        '??' => 's',
        '??' => 'T',
        '??' => 't',
        '??' => 'T',
        '??' => 't',
        '??' => 'T',
        '??' => 't',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'U',
        '??' => 'u',
        '??' => 'W',
        '??' => 'w',
        '??' => 'Y',
        '??' => 'y',
        '??' => 'Y',
        '??' => 'Z',
        '??' => 'z',
        '??' => 'Z',
        '??' => 'z',
        '??' => 'Z',
        '??' => 'z',
        '??' => 's',
    ];
}
