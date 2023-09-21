<?php

declare(strict_types=1);

namespace ZhandosProg\WriteSpelling\Spellings;

use ZhandosProg\WriteSpelling\AbstractWriteSpelling;
use ZhandosProg\WriteSpelling\Dictionaries\KazakhDictionary;
use ZhandosProg\WriteSpelling\Dictionaries\RussiaDictionary;
use ZhandosProg\WriteSpelling\Exceptions\NotSupportedException;
use ZhandosProg\WriteSpelling\Exceptions\ValidationException;

class NumberWriteSpelling extends AbstractWriteSpelling
{
    /**
     * @throws NotSupportedException
     * @throws ValidationException
     */
    public function generate(int|float|string $number, string $locale = 'kz'): string
    {
        $number = (string)$number;

        if (!in_array($locale, self::LOCALIZATIONS)) {
            throw new NotSupportedException('Localization '. strtoupper($locale) .' not supported!');
        }

        if (!preg_match('/^\d+(\.?\d*)$/', $number)) {
            throw new ValidationException('Incorrect number format!');
        }

        $words = $locale === 'ru' ? RussiaDictionary::$words : KazakhDictionary::$words;

        list($whole, $tenthOrHundredth) = explode('.', sprintf("%015.2f", floatval($number)));

        $result = [];

        if (intval($whole) > 0) {

            foreach(str_split($whole, 3) as $key => $v) {

                if (!intval($v)) {
                    continue;
                }

                $key = sizeof($words['units']) - $key - 1;

                $gender = $words['units'][$key][3];

                if ($tenthOrHundredth && $tenthOrHundredth !== '00') {
                    $gender = 1;
                }

                list($i1, $i2, $i3) = array_map('intval', str_split($v));

                $result[] = $words['hundreds'][$i1];

                if ($i2 > 1) {
                    $result[] = $words['hundredths2'][$i2] . ' ' . $words['tenths'][$gender][$i3];
                } else {
                    $result[] = $i2 > 0 ? $words['hundredths1'][$i3] : $words['tenths'][$gender][$i3];
                }

                if ($key > 1) {
                    $result[] = $this->morph($v, $words['units'][$key][0], $words['units'][$key][1], $words['units'][$key][2]);
                }
            }
        } else {
            $result[] = $words['zero'];
        }

        if ($tenthOrHundredth && $tenthOrHundredth !== '00') {
            $result[] = $this->morphWhole($whole, $words['percent'][1][0], $words['percent'][1][1]);
        }

        if ($tenthOrHundredth > 0) {

            if (str_starts_with($tenthOrHundredth, '0')) {
                $result[] = $words['tenths'][0][substr($tenthOrHundredth, 1, 1)];
            } elseif (str_ends_with($tenthOrHundredth, '0')) {
                $result[] = substr($tenthOrHundredth, 0, 1) == 1
                    ? $words['hundredths1'][0]
                    : $words['hundredths2'][substr($tenthOrHundredth, 0, 1)];
            } else {
                list($i1, $i2) = array_map('intval', str_split($tenthOrHundredth));

                if ($i1 > 1) {
                    $result[] = $words['hundredths2'][$i1] . ' ' . $words['tenths'][0][$i2];
                } else {
                    $result[] = $words['hundredths1'][$i1];
                }
            }

            $result[] = $this->morphTenthOrHundredth($tenthOrHundredth, $words['percent'][2], $words['percent'][3]);
        }

        return trim(preg_replace('/ {2,}/', ' ', join(' ', $result)));
    }
}
