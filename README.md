|![](https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/Warning.svg/156px-Warning.svg.png) | This project is no longer supported.
|---|---|

# rdomenzain/cfdi33-utils

[![Source Code][badge-source]][source]
[![Issues][badge-issues]][issues]
[![Software License][badge-license]][license]
[![Total Downloads][badge-downloads]][downloads]
[![Pagina Web][badge-pagina]][pagina]
[![GIT][badge-git]][git]

> Utilerias para la todo lo relacionado a la generacion del CFDI 3.3 del SAT México.

Esta libreria contiene utilidades desde el manejo de certificados con SSH, generación del XML, sellado del XML, utilerias generales como fechas, generación de QR, etc...

## Installation

Use [composer](https://getcomposer.org/), so please run

```shell
composer require rdomenzain/cfdi33-utils
```
## How create XML CFDI 3.3 

```php
<?php

// create XML...
$comprobante = new Comprobante();
$comprobante->Serie = "0A";
$comprobante->Folio = "11";
$comprobante->FormaPago = "03";
$comprobante->...

$emisor = new Emisor();
$emisor->Rfc = "XAXX010101000";
$emisor->Nombre = "Publico General";
$emisor->RegimenFiscal = "608";
$comprobante->Emisor = $emisor;

$cfdi = new Cfdv33($comprobante, $rutaCert, $rutaKey);
// This XML is already signed by the certificate and primary key
// Is ready to send to the favorite PAC
echo $cfdi->getXml();

```
## How signed only the XML
```php
<?php
// Declare utils
$utlXml = new XmlUtils();

// Get original string from the XML
$cadenaOriginal = $utlXml->GeneraCadenaOriginal(file_get_contents($pathXml));

// generated sign from original string, this add to the XML
$sello = $this->utlXml->GeneralSelloCfdi33($cadenaOriginal, file_get_contents($rutaKey), $claveKey);

```

## How get certificate and certificate number
```php
<?php
// Certificate utilities declared
$utlCert = new CertificadoUtils();

// Get the bash from to certificate, this add to the XML
$certificado = $utlCert->GeneraCertificado2Pem(file_get_contents($rutaCert));

// Get the certificate number from file .cer, this add to the XML
$noCertificado = $utlCert->GetNumCertificado(file_get_contents($rutaCert));

```

## Otras utilidades sobre CFDI 33
```php
<?php
// Certificate utilities declared
$utlCert = new CertificadoUtils();
$utlCommons = new CommonsUtils();

// Get date format requiered for the XML
echo $utlCommons->GetFechaActualCFDI();
// Out: 2019-10-18T13:21:36

// Replace characters especial
echo $utlCommons->ReplaceEncodeUtf8('Asociados&Otros');
// Out: Asociados&amp;Otros

// Formato to numbers
echo $utlCommons->FormatNumber(100, 2)
// Out: 100.00

// Validate certificate
echo $utlCert->ValidateCertificado(file_get_contents($rutaCert));
// Out: Certificado emitido por el SAT.

// Validate file primary key
echo  $utlCert->ValidatePrivateKey(file_get_contents($rutaKey));
// Out: Certificado emitido por el SAT.

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
[git]: https://packagist.org/packages/rdomenzain
[pagina]: https://ddsis.com.mx
[issues]: https://github.com/rdomenzain/cfdi33-utils/issues

[badge-source]: https://img.shields.io/badge/source-cfdi33--utils-blue?style=flat-square
[badge-license]: https://img.shields.io/badge/licence-MIT-red?style=flat-square
[badge-downloads]: https://img.shields.io/github/downloads/rdomenzain/cfdi33-utils/total?style=flat-square
[badge-git]: https://img.shields.io/github/followers/rdomenzain?label=rdomenzain&style=social
[badge-pagina]: https://img.shields.io/badge/Web-DDsis-lightgrey?style=flat-square
[badge-issues]: https://img.shields.io/github/issues/rdomenzain/cfdi33-utils?style=flat-square
