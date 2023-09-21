<?php

declare(strict_types=1);

namespace ZhandosProg\WriteSpelling\Tests\Spellings;

use ZhandosProg\WriteSpelling\Exceptions\NotSupportedException;
use ZhandosProg\WriteSpelling\Exceptions\ValidationException;
use ZhandosProg\WriteSpelling\Spellings\NumberWriteSpelling;
use PHPUnit\Framework\TestCase;

class NumberWriteSpellingTest extends TestCase
{
    public function testGenerateRu(): void
    {
        $expected = 'двенадцать целых девяносто девять сотых';
        $actual = (new NumberWriteSpelling())->generate(12.99,'ru');
        $this->assertEquals($expected, $actual);
    }

    public function testGenerateKz(): void
    {
        $expected = 'он екі бүтін тоқсан тоғыз жүзден';
        $actual = (new NumberWriteSpelling())->generate(12.99);
        $this->assertEquals($expected, $actual);
    }

    public function testGenerateValidationException(): void
    {
        $amountWriteSpelling = new NumberWriteSpelling();

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Incorrect number format!');

        $amountWriteSpelling->generate('1asd');
    }

    public function testGenerateNotSupportedException(): void
    {
        $locale = 'en';
        $amountWriteSpelling = new NumberWriteSpelling();

        $this->expectException(NotSupportedException::class);
        $this->expectExceptionMessage('Localization '. strtoupper($locale) .' not supported!');

        $amountWriteSpelling->generate(12, $locale);
    }
}
