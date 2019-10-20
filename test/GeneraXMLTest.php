<?php

require_once './../src/models/Complemento.php';
require_once './../src/models/Comprobante.php';

require_once './../src/models/Conceptos/Conceptos.php';
require_once './../src/models/Conceptos/Concepto.php';
require_once './../src/models/Conceptos/Impuestos.php';
require_once './../src/models/Conceptos/Traslado.php';
require_once './../src/models/Conceptos/Traslados.php';

require_once './../src/models/Emisor/Emisor.php';
require_once './../src/models/Receptor/Receptor.php';

require_once './../src/utils/CertificadoUtils.php';
require_once './../src/utils/XmlUtils.php';
require_once './../src/utils/CommonsUtils.php';

require_once './../src/core/Cfdv33.php';

require_once './../src/core/NodeCfdiRelacionados.php';
require_once './../src/core/NodeCfdiRelacionados.php';
require_once './../src/core/NodeEmisor.php';
require_once './../src/core/NodeReceptor.php';
require_once './../src/core/NodeConceptos.php';
require_once './../src/core/NodeImpuestos.php';

use rdomenzain\cfdi\utils\core\Cfdv33;
use rdomenzain\cfdi\utils\models\Complemento;
use rdomenzain\cfdi\utils\models\Comprobante;
use rdomenzain\cfdi\utils\models\Conceptos\Conceptos;
use rdomenzain\cfdi\utils\models\Conceptos\Concepto;
use rdomenzain\cfdi\utils\models\Conceptos\Impuestos;
use rdomenzain\cfdi\utils\models\Conceptos\Traslado;
use rdomenzain\cfdi\utils\models\Conceptos\Traslados;
use rdomenzain\cfdi\utils\models\Emisor\Emisor;
use rdomenzain\cfdi\utils\models\Receptor\Receptor;
use rdomenzain\cfdi\utils\utils\CertificadoUtils;
use rdomenzain\cfdi\utils\utils\XmlUtils;

// use rdomenzain\cfdi\utils\utils\CommonsUtils;

$comprobante = new Comprobante();
$comprobante->Serie = "0A";
$comprobante->Folio = "11";
$comprobante->FormaPago = "03";
$comprobante->CondicionesDePago = "Contado";
$comprobante->SubTotal = "1.00";
$comprobante->Descuento = "0.00";
$comprobante->Moneda = "MXN";
$comprobante->TipoCambio = "1";
$comprobante->Total= "1.16";
$comprobante->TipoDeComprobante = "I";
$comprobante->MetodoPago = "PUE";
$comprobante->LugarExpedicion = "11410";
$emisor = new Emisor();
$emisor->Nombre = "ACCEM SERVICIOS EMPRESARIALES";
$emisor->Rfc = "AAA010101AAA";
$emisor->RegimenFiscal = "601";
$comprobante->Emisor = $emisor;
$receptor = new Receptor();
$receptor->Nombre = "CLIENTES MOSTRADOR";
$receptor->Rfc = "XAXX010101000";
$receptor->UsoCFDI = "G01";
$comprobante->Receptor = $receptor;
// Agrega conceptos
$conceptos = new Conceptos();
$conceptosAll = array();
// Concepto 1
$concep = new Concepto();
$imp = new Impuestos();
$trasl = new Traslados();
$tras = new Traslado();
$tras->Base = "1.00";
$tras->Impuesto = "002";
$tras->TipoFactor = "Tasa";
$tras->TasaOCuota = "0.160000";
$tras->Importe = "0.16";
$trasl->Traslado = array($tras);
$imp->Traslados = $trasl;
$concep->ClaveProdServ = "01010101";
$concep->ClaveUnidad = "EA";
$concep->NoIdentificacion = "101PS22L1.90B/G";
$concep->Cantidad = "1.00";
$concep->Unidad = "Pza";
$concep->Descripcion = "R-101 PRIM  PINTRO STD Cal22 L1.90 mts Blanco/Gris";
$concep->ValorUnitario = "1.00";
$concep->Importe = "1.00";
$concep->Impuestos = $imp;
$concep->Descuento = "0.00";
$conceptos->Concepto = array($concep);
$comprobante->Conceptos = $conceptos;
// Impuestos
$impuestos = new Impuestos();
        
$traslados = new Traslados();
$tr = new Traslado();
$tr->Impuesto = "002";
$tr->TipoFactor = "Tasa";
$tr->TasaOCuota = "0.160000";
$tr->Importe = "0.16";
$traslados->Traslado = array($tr);
$impuestos->Traslados = $traslados;
$impuestos->TotalImpuestosRetenidos = "0.00";
$impuestos->TotalImpuestosTrasladados = "0.16";
$comprobante->Impuestos = $impuestos;
// Genera complementos
$complemento = new Complemento();
/*
// Genera complemento EstadoDeCuentaCombustible
$ecc11 = new EstadoDeCuentaCombustible();
$ecc11->NumeroDeCuenta = "1025";
$ecc11->SubTotal = "25.00";
$ecc11->TipoOperacion = "Tarjeta";
$ecc11->Total = "30.00";
$con1 = new ConceptoEstadoDeCuentaCombustible();
$con1->Identificador = "ABC";
$con1->Rfc = "XAXX010101000";
$con1->ClaveEstacion = "02";
$con1->TAR = "617";
$con1->Cantidad = "2.00";
$con1->NoIdentificacion = "Otros";
$con1->Unidad = "PZ";
$con1->NombreCombustible = "DIESEL";
$con1->FolioOperacion = "256";
$con1->ValorUnitario = "25.00";
$con1->Importe = "25.00";
$tras1 = new TrasladoECC();
$tras1->Importe = "203.00";
$tras1->Impuesto = "IVA";
$tras1->TasaoCuota = "23.00";
$con1->TrasladosECC = array($tras1);
$ecc11->ConceptosECC = array($con1);
$complemento->EstadoDeCuentaCombustible = $ecc11;
// Genera complemento Donatarias
$donatarias = new Donatarias();
$donatarias->noAutorizacion = "201586";
$donatarias->leyenda = "Este importe corresponde a una donación";
$donatarias->fechaAutorizacion = date("Y-m-d");
$complemento->Donatarias = $donatarias;
// Genera complemento Divisas
$divisas = new Divisas();
$divisas->tipoOperacion = "venta";
$complemento->Divisas = $divisas;
*/
// Genera complemento impuestos locales
/*
$impLoc = new ImpuestosLocales();
$impLoc->TotaldeRetenciones = "500.00";
$impLoc->TotaldeTraslados = "500.00";
$RetLoc = new RetencionesLocales();
$RetLoc->ImpLocRetenido = "Retención 5 % al millar";
$RetLoc->TasadeRetencion = "5.00";
$RetLoc->Importe = "500.00";
$impLoc->RetencionesLocales = array($RetLoc);
$TraLoc = new TrasladosLocales();
$TraLoc->ImpLocTrasladado = "5 % al millar";
$TraLoc->TasadeTraslado = "5.00";
$TraLoc->Importe = "500.00";
$impLoc->TrasladosLocales = array($TraLoc);
$complemento->ImpuestosLocales = $impLoc;
*/
/*
// Genera complemento Leyendas
$leyendasFis = new LeyendasFiscales();
$ley = new Leyenda();
$ley->disposicionFiscal = "LISR 2014";
$ley->norma = "Sección I, Capítulo II, Título IV";
$ley->textoLeyenda = "DE LAS PERSONAS FÍSICAS CON ACTIVIDADES EMPRESARIALES Y PROFESIONALES";
$leyendasFis->Leyenda = array($ley);
$complemento->LeyendasFiscales = $leyendasFis;
*/
// Genera complemento PFintegranteCoordinado
/*
$pfint = new PFintegranteCoordinado();
$pfint->ClaveVehicular = "RP37821FG721023HN";
$pfint->Placa = "FJC-78-67";
$pfint->RFCPF = "AAA010101AAA";
$complemento->PFintegranteCoordinado = $pfint;
*/
/*
// Genera complemento TuristaPasajeroExtranjero
$tpe = new TuristaPasajeroExtranjero();
$tpe->fechadeTransito = "07/12/2017 13:11:02";
$tpe->tipoTransito = "Salida";
$tpe->datosTransito = new datosTransito();
$tpe->datosTransito->Via = "Aérea";
$tpe->datosTransito->TipoId = "832912830-E2341";
$tpe->datosTransito->NumeroId = "EGA93812273-PLM3821";
$tpe->datosTransito->Nacionalidad = "GRECIA";
$tpe->datosTransito->EmpresaTransporte = "IBERIA";
$tpe->datosTransito->IdTransporte = "MX8321/GC9328";
$complemento->TuristaPasajeroExtranjero = $tpe;
*/
/*
// Genera complemento Complemento_SPEI
$spei = new Complemento_SPEI();
$spei1 = new SPEI_Tercero();
$spei1->ClaveSPEI = 87265;
$spei1->FechaOperacion = "2017-12-10";
$spei1->Hora = "13:20:10";
$spei1->cadenaCDA = "cadenaCDA1";
$spei1->numeroCertificado = "00001000000482505796";
$spei1->sello = "NjJVo5KxQEzGqfToe7ukQCVJrNY9lyciTmVB2wqlFmr/KZh+hsdb3S/95JlqrHS4DCFYKJuBcsdu7eeuaKu9fMBlGytiONOU5yNQkHX17MqAb62ChuoYuT+A/NiE=";
$spei1->Ordenante = new Ordenante();
$spei1->Ordenante->BancoEmisor = "Banco del Norte S.A.";
$spei1->Ordenante->Cuenta = "83927635620125364729";
$spei1->Ordenante->Nombre = "Gustavo Fernández Sánchez";
$spei1->Ordenante->RFC = "AAA010101AAA";
$spei1->Ordenante->TipoCuenta = "06";
$spei1->Beneficiario = new Beneficiario();
$spei1->Beneficiario->BancoReceptor = "Banco del Sur S.A.";
$spei1->Beneficiario->Concepto = "Servicios de Minería";
$spei1->Beneficiario->Cuenta = "019236383749552321713";
$spei1->Beneficiario->IVA = "0.0";
$spei1->Beneficiario->MontoPago = "2450973.87";
$spei1->Beneficiario->Nombre = "Jesús Guzmán Lara";
$spei1->Beneficiario->RFC = "BBB010101BBB";
$spei1->Beneficiario->TipoCuenta = "05";
$spei->SPEI_Tercero = array($spei1);
$complemento->Complemento_SPEI = $spei;
// Agrega los complementos
$comprobante->Complemento = $complemento;
*/

$utlXml = new XmlUtils();
$utlCert = new CertificadoUtils();

$clave = "12345678a";
$rutaCert = realpath(dirname(__FILE__) . '/../docs/CSD_Prueba/AAA010101AAA.cer');
$rutaKey = realpath(dirname(__FILE__) . '/../docs/CSD_Prueba/AAA010101AAA.key');

$utlCert->ValidateCertificado(file_get_contents($rutaCert));
$utlCert->ValidatePrivateKey(file_get_contents($rutaKey));
print_r($utlCert->GetInfoCertificado(file_get_contents($rutaCert)));
echo '<br>';
$cfdi = new Cfdv33($comprobante, $rutaCert, $rutaKey, $clave);
// error_log($cfdi->getXml());
$xmlFile = dirname(__FILE__) . '\\pruebaXML.xml';
echo 'Archivo XML:: ' . $xmlFile;
echo '<br>';
echo base64_encode($cfdi->getXml());
$fp = fopen($xmlFile, 'wb');
fwrite($fp, $cfdi->getXml());
fclose($fp);