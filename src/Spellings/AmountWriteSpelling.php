<?php

declare(strict_types=1);

namespace ZhandosProg\WriteSpelling\Spellings;

use ZhandosProg\WriteSpelling\Dictionaries\KazakhDictionary;
use ZhandosProg\WriteSpelling\Dictionaries\RussiaDictionary;
use ZhandosProg\WriteSpelling\Exceptions\NotSupportedException;
use ZhandosProg\WriteSpelling\Exceptions\ValidationException;

class AmountWriteSpelling
{
    protected const LOCALIZATIONS = ['kz', 'ru'];

    /**
     * @throws NotSupportedException
     * @throws ValidationException
     */
    public function generate(int|float|string $number, string $locale = 'kz'): string
    {
        $number = (string)$number;

        if (!in_array($locale, static::LOCALIZATIONS)) {
            throw new NotSupportedException('Localization '. strtoupper($locale) .' not supported!');
        }

        if (!preg_match('/^\d+(\.?\d*)$/', $number)) {
            throw new ValidationException('Incorrect number format!');
        }

        $words = $locale === 'ru' ? RussiaDictionary::$words : KazakhDictionary::$words;

        list($tenge, $tiin) = explode('.', sprintf("%015.2f", floatval($number)));

        $result = [];

        if (intval($tenge) > 0) {

            foreach(str_split($tenge,3) as $key => $v) {

                if (!intval($v)) {
                    continue;
                }

                $key = sizeof($words['units'])-$key-1;
                $gender = $words['units'][$key][3];

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

        $result[] = $this->morph(intval($tenge), $words['units'][1][0], $words['units'][1][1], $words['units'][1][2]);

        if ($tiin > 0) {

            if (str_starts_with($tiin, '0')) {
                $result[] = $words['tenths'][0][substr($tiin, 1, 1)];
            } else if (str_ends_with($tiin, '0')) {
                $result[] = substr($tiin, 0, 1) == 1
                    ? $words['hundredths1'][0]
                    : $words['hundredths2'][substr($tiin, 0, 1)];
            } else {
                list($i1, $i2) = array_map('intval', str_split($tiin));

                if ($i1 > 1) {
                    $result[] = $words['hundredths2'][$i1] . ' ' . $words['tenths'][0][$i2];
                } else {
                    $result[] = $words['hundredths1'][$i1];
                }
            }

            $result[] = $this->morph($tiin, $words['units'][0][0], $words['units'][0][1], $words['units'][0][2]);
        }

        return trim(preg_replace('/ {2,}/', ' ', join(' ', $result)));
    }

    private function morph(string|int $n, string $f1, string $f2, string $f3): string
    {
        $n = abs(intval($n)) % 100;

        if ($n > 10 && $n < 20) {
            return $f3;
        }

        $n = $n % 10;

        if ($n > 1 && $n < 5) {
            return $f2;
        }

        if ($n === 1) {
            return $f1;
        }

        return $f3;
    }
}