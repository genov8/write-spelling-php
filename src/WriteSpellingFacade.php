<?php

declare(strict_types=1);

namespace ZhandosProg\WriteSpelling;

use ZhandosProg\WriteSpelling\Spellings\AmountWriteSpelling;
use ZhandosProg\WriteSpelling\Spellings\NumberWriteSpelling;
use ZhandosProg\WriteSpelling\Spellings\PercentWriteSpelling;

class WriteSpellingFacade
{
    private AmountWriteSpelling $amountSpelling;
    private NumberWriteSpelling $numberSpelling;
    private PercentWriteSpelling $percentSpelling;

    public function __construct()
    {
        $this->amountSpelling = new AmountWriteSpelling();
        $this->numberSpelling = new NumberWriteSpelling();
        $this->percentSpelling = new PercentWriteSpelling();
    }

    /**
     * @throws Exceptions\NotSupportedException
     * @throws Exceptions\ValidationException
     */
    public function spellAmount(int|float|string $number, string $locale = 'kz'): string
    {
        return $this->amountSpelling->generate($number, $locale);
    }

    /**
     * @throws Exceptions\NotSupportedException
     * @throws Exceptions\ValidationException
     */
    public function spellNumber(int|float|string $number, string $locale = 'kz'): string
    {
        return $this->numberSpelling->generate($number, $locale);
    }

    /**
     * @throws Exceptions\NotSupportedException
     * @throws Exceptions\ValidationException
     */
    public function spellPercent(int|float|string $number, string $locale = 'kz'): string
    {
        return $this->percentSpelling->generate($number, $locale);
    }
}