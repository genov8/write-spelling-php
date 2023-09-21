<?php

declare(strict_types=1);

namespace ZhandosProg\WriteSpelling;

abstract class AbstractWriteSpelling
{
    protected const LOCALIZATIONS = ['kz', 'ru'];

    abstract protected function generate(int|float|string $number): string;

    protected function morphWhole(string $number, string $f1, string $f2): string
    {
        if ($number === '1' || str_ends_with($number, '1')) {
            return $f2;
        }

        return $f1;
    }

    protected function morphTenthOrHundredth(string $number, array $tenth, array $hundredth): string
    {

        if ($number < '10') {
            return $number === '1' ? $tenth['1'] : $tenth['0'];
        }

        if ($number > '20') {
            return str_ends_with($number, '1') ? $hundredth['1'] : $hundredth['0'];
        }

        return $hundredth['0'];
    }

    protected function morph(string|int $n, string $f1, string $f2, string $f3): string
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
