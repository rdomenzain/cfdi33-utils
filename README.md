# rdomenzain/cfdi33-utils

[![Source Code][badge-source]][source]
[![Software License][badge-license]][license]
[![Total Downloads][badge-downloads]][downloads]

> Utilerias para la todo lo relacionado a la generacion del CFDI 3.3 del SAT México.

Esta libreria contiene utilidades desde el manejo de certificados con SSH, generación del XML, sellado del XML, utilerias generales como fechas, generación de QR, etc...

## Installation

Use [composer](https://getcomposer.org/), so please run

```shell
composer require rdomenzain/cfdi33-utils
```

## Basic usage as a PHP library

```php
<?php

// create the invoice as output.pdf
$converter->createPdfAs($cfdiData, 'output.pdf');
```

## PHP Support

This library is compatible with PHP versions 7.0 and above.
Please, try to use the full potential of the language.

## Contributing

Contributions are welcome! Please read [CONTRIBUTING][] for details
and don't forget to take a look in the [TODO][] and [CHANGELOG][] files.

## Copyright and License

The rdomenzain/cfdi33-utils library is copyright © [Ricardo Domenzain M.](https://ddsis.com.mx/)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.

[contributing]: https://github.com/rdomenzain/cfdi33-utils/blob/master/CONTRIBUTING.md
[changelog]: https://github.com/rdomenzain/cfdi33-utils/blob/master/docs/CHANGELOG.md
[todo]: https://github.com/rdomenzain/cfdi33-utils/blob/master/docs/TODO.md

[source]: https://github.com/rdomenzain/cfdi33-utils
[license]: https://github.com/rdomenzain/cfdi33-utils/blob/master/LICENSE
[downloads]: https://packagist.org/packages/rdomenzain/cfdi33-utils

[badge-source]: https://img.shields.io/badge/source-rdomenzain/cfdi33-utils-blue?style=flat-square
[badge-license]: https://img.shields.io/badge/licence-MIT-red
[badge-downloads]: https://img.shields.io/badge/downloads-%3E%20999-orange