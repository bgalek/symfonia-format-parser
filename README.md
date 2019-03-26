# Sage Symfonia Format 3.0 Parser
> Easy to use Sage Format 3.0 to PHP associative array converter

![Travis (.org)](https://img.shields.io/travis/bgalek/symfonia-format-parser.svg?style=flat-square)
![Codecov](https://img.shields.io/codecov/c/github/bgalek/symfonia-format-parser.svg?style=flat-square)
![Libraries.io dependency status for GitHub repo](https://img.shields.io/librariesio/github/bgalek/symfonia-format-parser.svg?style=flat-square)

## What's "Format 3.0"
**Format 3.0** is a default data exchange format for [https://www.sage.com.pl](Sage Applications). More information: [https://pomoc.sage.com.pl/data/hm/Symfonia/2017/data/wymiana_danych_format_3.htm](https://pomoc.sage.com.pl/data/hm/Symfonia/2017/data/wymiana_danych_format_3.htm)

## Installation
```bash
composer require bgalek/symfonia-format-parser
```
## Import
```php
use SymfoniaFormatParser\SymfoniaFormatParser;
```
## Usage
```php
$array = SymfoniaFormatParser::parse($input);
```