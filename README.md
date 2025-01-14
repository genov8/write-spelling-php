# WriteSpelling
Package for generating number, amount and percent in spelling

- [Requirements](#requirements)
- [Features](#features)
- [Localizations](#localizations)
- [Installation](#installation)
- [Usage](#usage)
- [Exceptions](#exceptions)
- [Backlog](#backlog)

## Requirements

- PHP >= 8.0

## Features

- [&check;] Generation amount in spelling
- [&check;] Generation percent in spelling
- [&check;] Generation number in spelling

## Localizations

- [✓] Kazakh default
- [✓] Russia

## Installation

```bash
composer require zhandos-prog/write-spelling
```

## Usage

#### Russian
```php

$amountSpelling = new \ZhandosProg\WriteSpelling\Spellings\AmountWriteSpelling();
$result1 = $amountSpelling->generate(42.42, 'ru');
var_dump($result1); // сорок два тенге сорок два тиын
$result2 = $amountSpelling->generate(42, 'ru');
var_dump($result2); // сорок два тенге

$percentSpelling = new \ZhandosProg\WriteSpelling\Spellings\PercentWriteSpelling();
$result1 = $percentSpelling->generate(42.42, 'ru')
var_dump($result1); // сорок две целых сорок две сотых процента
$result2 = $percentSpelling->generate(42, 'ru')
var_dump($resul2); // сорок два процента

$percentSpelling = new \ZhandosProg\WriteSpelling\Spellings\NumberWriteSpelling();
$result1 = $percentSpelling->generate(42.42, 'ru')
var_dump($result1); // сорок две целых сорок две сотых
$result2 = $percentSpelling->generate(42, 'ru')
var_dump($resul2); // сорок два

```

#### Kazakh
```php

$amountSpelling = new \ZhandosProg\WriteSpelling\Spellings\AmountWriteSpelling();
$result1 = $amountSpelling->generate(42.42);
var_dump($result1); // қырық екі теңге қырық екі тиын
$result2 = $amountSpelling->generate(42);
var_dump($result2); // қырық екі теңге

$percentSpelling = new \ZhandosProg\WriteSpelling\Spellings\PercentWriteSpelling();
$result1 = $percentSpelling->generate(42.42)
var_dump($result1); // қырық екі бүтін жүзден қырық екі пайыз
$result2 = $percentSpelling->generate(42)
var_dump($result2); // қырық екі пайыз

$percentSpelling = new \ZhandosProg\WriteSpelling\Spellings\NumberWriteSpelling();
$result1 = $percentSpelling->generate(42.42)
var_dump($result1); // қырық екі бүтін жүзден қырық екі
$result2 = $percentSpelling->generate(42)
var_dump($result2); // қырық екі

```

## Usage with facade

```php

$facade = new ZhandosProg\WriteSpelling\WriteSpellingFacade();

// Generating amounts
echo $facade->spellAmount(1234.56, 'ru'); // одна тысяча двести тридцать четыре тенге пятьдесят шесть тиын
echo $facade->spellAmount(987.01, 'kz'); // тоғыз жүз сексен жеті бүтін бір оннан

// Generating numbers
echo $facade->spellNumber(1234, 'ru'); // одна тысяча двести тридцать четыре
echo $facade->spellNumber(456, 'kz'); // төрт жүз елу алты

// Generating percentages
echo $facade->spellPercent(85.75, 'ru'); // восемьдесят пять целых семьдесят пять сотых процента
echo $facade->spellPercent(99.9, 'kz'); // тоқсан тоғыз бүтін оннан тоғыз пайыз

```

## Exceptions

- ``NotSupportedException``
- ``ValidationException``