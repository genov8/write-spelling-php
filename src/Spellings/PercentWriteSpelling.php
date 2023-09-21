<?php

declare(strict_types=1);

namespace ZhandosProg\WriteSpelling\Spellings;

use ZhandosProg\WriteSpelling\AbstractWriteSpelling;
use ZhandosProg\WriteSpelling\Dictionaries\KazakhDictionary;
use ZhandosProg\WriteSpelling\Dictionaries\RussiaDictionary;
use ZhandosProg\WriteSpelling\Exceptions\NotSupportedException;
use ZhandosProg\WriteSpelling\Exceptions\ValidationException;

class PercentWriteSpelling extends AbstractWriteSpelling
{
    /**
     * @throws NotSupportedException
     * @throws ValidationException
     */
    public function generate(string|int|float $number, string $locale = 'kz'): string
    {
        $number = (string)$number;

        if (!in_array($locale, self::LOCALIZATIONS)) {
            throw new NotSupportedException('Localization '. strtoupper($locale) .' not supported!');
        }

        if (!preg_match('/^\d+(\.?\d*)$/', $number)) {
            throw new ValidationException('Incorrect number format!');
        }

        if ($number < '0' || $number > '100') {
            throw new ValidationException('The percentage must have a range of 0 to 100!');
        }

        $words = $locale === 'ru' ? RussiaDictionary::$words : KazakhDictionary::$words;

        list($whole, $tenthOrHundredth) = explode('.', sprintf("%.2f", floatval($number)));

        $result = [];

        if (isset($words['percent'][0][$whole])) {
            $result[] = $words['percent'][0][$tenthOrHundredth > 0 ? $this->neg((int)$whole) : $whole];
        } else {
            for ($i = 0; $i < strlen($whole); $i++) {
                if ($i === 0) {
                    $result[] = $words['percent'][0][(int)$whole[$i] * 10];
                } else {
                    $result[] = $words['percent'][0][$tenthOrHundredth > 0 ? $this->neg((int)$whole[$i]) : $whole[$i]];
                }
            }
        }

        if ($tenthOrHundredth > 0) {

            $result[] = $this->morphWhole($whole, $words['percent'][1][0], $words['percent'][1][1]);

            if ($locale === 'kz') {
                $result[] = $this->morphTenthOrHundredth($tenthOrHundredth, $words['percent'][2], $words['percent'][3]);
            }

            $tenthOrHundredth = str_starts_with($tenthOrHundredth, '0')
                ? substr($tenthOrHundredth, 1, 1) : $tenthOrHundredth;

            if (isset($words['percent'][0][$tenthOrHundredth])) {
                $result[] = $words['percent'][0][$this->neg((int)$tenthOrHundredth)];
            } else {
                for ($i = 0; $i < strlen($tenthOrHundredth); $i++) {
                    if ($i === 0) {
                        $result[] = $words['percent'][0][(int)$tenthOrHundredth[$i] * 10];
                    } else {
                        $result[] = $words['percent'][0][$this->neg((int)$tenthOrHundredth[$i])];
                    }
                }
            }

            if ($locale === 'ru') {
                $result[] = $this->morphTenthOrHundredth($tenthOrHundredth, $words['percent'][2], $words['percent'][3]);
            }

            $result[] = $words['percent'][4][1];
        } else {
            $result[] = $this->morphPercent($whole, $words['percent'][4][0], $words['percent'][4][1], $words['percent'][4][2]);
        }

        return implode(' ', $result);
    }

    private function neg(int $number): int
    {
        if ($number === 1 || $number === 2) {
            return -1 * $number;
        }

        return $number;
    }

    private function morphPercent(string $number, string $f1, string $f2, string $f3): string
    {
        if ($number === '1' || $number > '20' && str_ends_with($number, '1')) {
            return $f1;
        }

        if ($number > '1' && $number < '5' ||
            substr($number, 1, 1) > '1' && substr($number, 1, 1) < '5' && $number > 20) {
            return $f2;
        }

        return $f3;
    }
}
