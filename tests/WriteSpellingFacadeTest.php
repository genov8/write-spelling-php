<?php

declare(strict_types=1);

namespace ZhandosProg\WriteSpelling\Tests;

use ZhandosProg\WriteSpelling\Exceptions\NotSupportedException;
use ZhandosProg\WriteSpelling\Exceptions\ValidationException;
use ZhandosProg\WriteSpelling\WriteSpellingFacade;
use PHPUnit\Framework\TestCase;

class WriteSpellingFacadeTest extends TestCase
{
    private WriteSpellingFacade $facade;

    protected function setUp(): void
    {
        $this->facade = new WriteSpellingFacade();
    }

    /**
     * @throws NotSupportedException
     * @throws ValidationException
     */
    public function testSpellAmount(): void
    {
        $expectedRu = 'двенадцать тенге девяносто девять тиын';
        $actualRu = $this->facade->spellAmount(12.99, 'ru');
        $this->assertIsString($actualRu, 'The result of spellAmount for RU should be a string.');
        $this->assertNotEmpty($actualRu, 'The result of spellAmount for RU should not be empty.');
        $this->assertEquals($expectedRu, $actualRu, 'The RU result of spellAmount should match the expected value.');

        $expectedKz = 'он екі теңге тоқсан тоғыз тиын';
        $actualKz = $this->facade->spellAmount(12.99, 'kz');
        $this->assertIsString($actualKz, 'The result of spellAmount for KZ should be a string.');
        $this->assertNotEmpty($actualKz, 'The result of spellAmount for KZ should not be empty.');
        $this->assertEquals($expectedKz, $actualKz, 'The KZ result of spellAmount should match the expected value.');
    }

    /**
     * @throws NotSupportedException
     * @throws ValidationException
     */
    public function testSpellNumber(): void
    {
        $expectedKz = 'тоғыз жүз сексен жеті';
        $actualKz = $this->facade->spellNumber(987, 'kz');
        $this->assertIsString($actualKz, 'The result of spellNumber for KZ should be a string.');
        $this->assertNotEmpty($actualKz, 'The result of spellNumber for KZ should not be empty.');
        $this->assertEquals($expectedKz, $actualKz, 'The KZ result of spellNumber should match the expected value.');

        $expectedRu = 'девятьсот восемьдесят семь';
        $actualRu = $this->facade->spellNumber(987, 'ru');
        $this->assertIsString($actualRu, 'The result of spellNumber for RU should be a string.');
        $this->assertNotEmpty($actualRu, 'The result of spellNumber for RU should not be empty.');
        $this->assertEquals($expectedRu, $actualRu, 'The RU result of spellNumber should match the expected value.');
    }

    /**
     * @throws NotSupportedException
     * @throws ValidationException
     */
    public function testSpellPercent(): void
    {
        $expectedKz = 'сексен бес бүтін жүзден жетпіс бес пайыз';
        $actualKz = $this->facade->spellPercent(85.75, 'kz');
        $this->assertIsString($actualKz, 'The result of spellPercent for KZ should be a string.');
        $this->assertNotEmpty($actualKz, 'The result of spellPercent for KZ should not be empty.');
        $this->assertEquals($expectedKz, $actualKz, 'The KZ result of spellPercent should match the expected value.');

        $expectedRu = 'восемьдесят пять целых семьдесят пять сотых процента';
        $actualRu = $this->facade->spellPercent(85.75, 'ru');
        $this->assertIsString($actualRu, 'The result of spellPercent for RU should be a string.');
        $this->assertNotEmpty($actualRu, 'The result of spellPercent for RU should not be empty.');
        $this->assertEquals($expectedRu, $actualRu, 'The RU result of spellPercent should match the expected value.');
    }

    /**
     * @throws ValidationException
     */
    public function testUnsupportedLocale(): void
    {
        $this->expectException(NotSupportedException::class);
        $this->facade->spellAmount(1234.56, 'en');
    }

    /**
     * @throws NotSupportedException
     */
    public function testInvalidNumberFormat(): void
    {
        $this->expectException(ValidationException::class);
        $this->facade->spellAmount('1asd', 'kz');
    }
}
