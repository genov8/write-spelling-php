<?php

declare(strict_types=1);

namespace ZhandosProg\WriteSpelling\Tests\Spellings;

use PHPUnit\Framework\TestCase;
use ZhandosProg\WriteSpelling\Exceptions\NotSupportedException;
use ZhandosProg\WriteSpelling\Exceptions\ValidationException;
use ZhandosProg\WriteSpelling\Spellings\PercentWriteSpelling;

class PercentWriteSpellingTest extends TestCase
{

    public function testGenerateRu(): void
    {
        $expected = 'сорок две целых сорок две сотых процента';
        $actual = (new PercentWriteSpelling())->generate(42.42,'ru');
        $this->assertEquals($expected, $actual);

        $expected = 'сорок два процента';
        $actual = (new PercentWriteSpelling())->generate(42,'ru');
        $this->assertEquals($expected, $actual);
    }

    public function testGenerateKz(): void
    {
        $expected = 'қырық екі бүтін жүзден қырық екі пайыз';
        $actual = (new PercentWriteSpelling())->generate(42.42);
        $this->assertEquals($expected, $actual);

        $expected = 'қырық екі пайыз';
        $actual = (new PercentWriteSpelling())->generate(42);
        $this->assertEquals($expected, $actual);
    }

    public function testGenerateNumberFormatValidationException(): void
    {
        $amountWriteSpelling = new PercentWriteSpelling();

        $this->expectException(ValidationException::class);
        $this->expectErrorMessage('Incorrect number format!');

        $amountWriteSpelling->generate('1asd');
    }

    public function testGenerateRangePercentValidationException(): void
    {
        $amountWriteSpelling = new PercentWriteSpelling();

        $this->expectException(ValidationException::class);
        $this->expectErrorMessage('The percentage must have a range of 0 to 100!');

        $amountWriteSpelling->generate('101');
    }

    public function testGenerateNotSupportedException(): void
    {
        $locale = 'en';
        $amountWriteSpelling = new PercentWriteSpelling();

        $this->expectException(NotSupportedException::class);
        $this->expectErrorMessage('Localization '. strtoupper($locale) .' not supported!');

        $amountWriteSpelling->generate(12, $locale);
    }
}
