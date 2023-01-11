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
- [&cross;] Generation number in spelling

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
var_dump($result1); 
$result2 = $percentSpelling->generate(42, 'ru')
var_dump($resul2); // сорок два процента

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

```

## Exceptions

- ``NotSupportedException``
- ``ValidationException``

## Backlog
The package lacks refactoring, so for now we do not pay attention to the code. The task was to make a working functional! :-)

What is to be done:
- Do code analysis
- Add abstraction
- Refactoring generation code, redo dictionaries
- Make a facade
- Add number generation
- ...
- ...

If possible, I will keep the package up to date and add upcoming tasks!
