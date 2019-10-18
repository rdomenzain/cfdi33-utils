<?php

namespace rdomenzain\cfdi\utils\core;

use DOMDocument;
use rdomenzain\cfdi\utils\utils\CertificadoUtils;
use rdomenzain\cfdi\utils\utils\CommonsUtils;
use rdomenzain\cfdi\utils\utils\XmlUtils;

class Cfdv33
{
    private $xml;
    private $cfdiElement;
    private $schemaLocation;
    private $strUtil;
    private $utlXml;
    private $utlCert;
    private $cadenaOriginal;
    private $sello;
    private $certificado;
    private $noCertificado;
    private $rutaCert;
    private $rutaKey;
    private $claveKey;
    private $fechaEmision;

    /**
     * Metodo constructor de la clase principal de generacion de XML
     * @param Comprobante $comprobante
     */
    public function __construct($comprobante, $rutaCert, $rutaKey, $claveKey)
    {
        // Setea variables
        $this->rutaCert = $rutaCert;
        $this->rutaKey = $rutaKey;
        $this->claveKey = $claveKey;
        // Inicializa Utilidades
        $this->strUtil = new CommonsUtils();
        $this->utlXml = new XmlUtils();
        $this->utlCert = new CertificadoUtils();
        // Prepara generacion de XML
        $this->xml = new DOMDocument("1.0", "UTF-8");
        $this->schemaLocation = "";
        $this->cadenaOriginal = "";
        $this->sello = "";
        $this->certificado = "";
        $this->noCertificado = "";
        $this->fechaEmision = $this->strUtil->GetFechaActualCFDI();
        // Genera el XML
        $this->generaEstructura();
        $this->generaDatosGenerales($comprobante);
        $this->generaNodosPrincipales($comprobante);
        $this->generaComplementos($comprobante);
    }

    /**
     * Genera la estructura principal del XML
     */
    private function generaEstructura()
    {
        // Crea nodo principal
        $this->cfdiElement = $this->xml->createElement("cfdi:Comprobante");
        // Agrega atributo del cfdi
        $atributeCfdi = $this->xml->createAttribute('xmlns:cfdi');
        $atributeCfdi->value = "http://www.sat.gob.mx/cfd/3";
        $this->cfdiElement->appendChild($atributeCfdi);
        // Agrega atributo del esquema Inctance
        $attrSchemaInstance = $this->xml->createAttribute('xmlns:xsi');
        $attrSchemaInstance->value = "http://www.w3.org/2001/XMLSchema-instance";
        $this->cfdiElement->appendChild($attrSchemaInstance);
        // Inicializa la variable de las locaciones principales
        $this->schemaLocation = $this->schemaLocation . "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd";
    }

    /**
     * Genera los Schema Location usados
     */
    private function generaSchemaLocation()
    {
        // Agrega atributo de location
        $atribute = $this->xml->createAttribute('xsi:schemaLocation');
        $atribute->value = $this->schemaLocation;
        $this->cfdiElement->appendChild($atribute);
    }

    /**
     * Se encarga de generar los atributos generales
     * @param Comprobante $comprobante
     */
    private function generaDatosGenerales($comprobante)
    {
        // Agrega version
        $Version = $this->xml->createAttribute('Version');
        $Version->value = "3.3";
        $this->cfdiElement->appendChild($Version);
        // Agrega Fecha
        $Fecha = $this->xml->createAttribute('Fecha');
        $Fecha->value = $this->fechaEmision;
        $this->cfdiElement->appendChild($Fecha);
        //Agrega Serie
        if ($comprobante->Serie != null && !empty($comprobante->Serie)) {
            $attr = $this->xml->createAttribute('Serie');
            $attr->value = $comprobante->Serie;
            $this->cfdiElement->appendChild($attr);
        }
        //Agrega Folio
        if ($comprobante->Folio != null && !empty($comprobante->Folio)) {
            $attr = $this->xml->createAttribute('Folio');
            $attr->value = $comprobante->Folio;
            $this->cfdiElement->appendChild($attr);
        }
        //Agrega Forma de Pago
        if ($comprobante->FormaPago != null && !empty($comprobante->FormaPago)) {
            $attr = $this->xml->createAttribute('FormaPago');
            $attr->value = $comprobante->FormaPago;
            $this->cfdiElement->appendChild($attr);
        }
        //Agrega Condicion Pago
        if ($comprobante->CondicionesDePago != null && !empty($comprobante->CondicionesDePago)) {
            $attr = $this->xml->createAttribute('CondicionesDePago');
            $attr->value = $comprobante->CondicionesDePago;
            $this->cfdiElement->appendChild($attr);
        }
        // Agrega Subtotal
        $SubTotal = $this->xml->createAttribute('SubTotal');
        $SubTotal->value = $comprobante->SubTotal;
        $this->cfdiElement->appendChild($SubTotal);
        //Agrega Descuento
        if ($comprobante->Descuento != null && !empty($comprobante->Descuento)) {
            $attr = $this->xml->createAttribute('Descuento');
            $attr->value = $comprobante->Descuento;
            $this->cfdiElement->appendChild($attr);
        }
        // Agrega Moneda
        $Moneda = $this->xml->createAttribute('Moneda');
        $Moneda->value = $comprobante->Moneda;
        $this->cfdiElement->appendChild($Moneda);
        //Agrega Tipo Cambio
        if ($comprobante->TipoCambio != null && !empty($comprobante->TipoCambio)) {
            $attr = $this->xml->createAttribute('TipoCambio');
            $attr->value = $comprobante->TipoCambio;
            $this->cfdiElement->appendChild($attr);
        }
        // Agrega Total
        $Total = $this->xml->createAttribute('Total');
        $Total->value = $comprobante->Total;
        $this->cfdiElement->appendChild($Total);
        // Agrega Tipo Comprobante
        $TipoDeComprobante = $this->xml->createAttribute('TipoDeComprobante');
        $TipoDeComprobante->value = $comprobante->TipoDeComprobante;
        $this->cfdiElement->appendChild($TipoDeComprobante);
        //Agrega Metodo de pago
        if ($comprobante->MetodoPago != null && !empty($comprobante->MetodoPago)) {
            $attr = $this->xml->createAttribute('MetodoPago');
            $attr->value = $comprobante->MetodoPago;
            $this->cfdiElement->appendChild($attr);
        }
        //Agrega Lugar de expecidion
        $LugarExpedicion = $this->xml->createAttribute('LugarExpedicion');
        $LugarExpedicion->value = $comprobante->LugarExpedicion;
        $this->cfdiElement->appendChild($LugarExpedicion);
        //Agrega Confirmacion
        if ($comprobante->Confirmacion != null && !empty($comprobante->Confirmacion)) {
            $attr = $this->xml->createAttribute('Confirmacion');
            $attr->value = $comprobante->Confirmacion;
            $this->cfdiElement->appendChild($attr);
        }
    }

    /**
     * Se encarga de generar los atributos generales
     * @param Comprobante $comprobante
     */
    private function generaNodosPrincipales($comprobante)
    {
        // Agrega Nodo de Cfdi relacionados
        $nodeCfdiRel = new NodeCfdiRelacionados($comprobante->CfdiRelacionados, $this->xml);
        $nodeValCfdiRel = $nodeCfdiRel->GeneraNodo();
        if ($nodeValCfdiRel != null) {
            $this->cfdiElement->appendChild($nodeValCfdiRel);
        }
        // Agrega Nodo de Emisor
        $nodeEmisor = new NodeEmisor($comprobante->Emisor, $this->xml);
        $nodeValEmisor = $nodeEmisor->GeneraNodo();
        if ($nodeValEmisor != null) {
            $this->cfdiElement->appendChild($nodeValEmisor);
        }
        // Agrega node de Receptor
        $nodeReceptor = new NodeReceptor($comprobante->Receptor, $this->xml);
        $nodeValReceptor = $nodeReceptor->GeneraNodo();
        if ($nodeValReceptor != null) {
            $this->cfdiElement->appendChild($nodeValReceptor);
        }
        // Agrega node de Conceptos
        $nodeConceptos = new NodeConceptos($comprobante->Conceptos, $this->xml);
        $nodeValConceptos = $nodeConceptos->GeneraNodo();
        if ($nodeValConceptos != null) {
            $this->cfdiElement->appendChild($nodeValConceptos);
        }
        // Agrega node de Impuestos
        $nodeImpuestos = new NodeImpuestos($comprobante->Impuestos, $this->xml);
        $nodeValImp = $nodeImpuestos->GeneraNodo();
        if ($nodeValImp != null) {
            $this->cfdiElement->appendChild($nodeValImp);
        }
    }

    /**
     * Genera los complementos del comprobantes
     * @param Comprobante $comprobante
     */
    private function generaComplementos($comprobante)
    {
        // Genera complemento si existe
        if ($comprobante->Complemento != null && !empty($comprobante->Complemento)) {
            // Agrega nodo de complemento
            $complementoElement = $this->xml->createElement("cfdi:Complemento");
            $complemento = $comprobante->Complemento;
            // Genera complemento de EstadoDeCuentaCombustible
            if ($complemento->EstadoDeCuentaCombustible != null && !empty($complemento->EstadoDeCuentaCombustible)) {
                $ecc11 = new ComplementoEcc11($complemento->EstadoDeCuentaCombustible, $this->xml);
                $complementoElement->appendChild($ecc11->GeneraComplemento());
            }
            // Genera complemento de Donatarias
            if ($complemento->Donatarias != null && !empty($complemento->Donatarias)) {
                // Agrega el namespace
                $xmlns = $this->xml->createAttribute("xmlns:donat");
                $xmlns->value = "http://www.sat.gob.mx/donat";
                $this->cfdiElement->appendChild($xmlns);
                // Agrega Schema
                $this->schemaLocation = $this->schemaLocation . " http://www.sat.gob.mx/donat http://www.sat.gob.mx/sitio_internet/cfd/donat/donat11.xsd";
                // Genera complemento Donatarias
                $donatarias = new ComplementoDonatarias($complemento->Donatarias, $this->xml);
                $complementoElement->appendChild($donatarias->GeneraComplemento());
            }
            // Genera complemento de Donatarias
            if ($complemento->Divisas != null && !empty($complemento->Divisas)) {
                // Agrega el namespace
                $xmlns = $this->xml->createAttribute("xmlns:divisas");
                $xmlns->value = "http://www.sat.gob.mx/divisas";
                $this->cfdiElement->appendChild($xmlns);
                // Agrega Schema
                $this->schemaLocation = $this->schemaLocation . " http://www.sat.gob.mx/divisas http://www.sat.gob.mx/sitio_internet/cfd/divisas/divisas.xsd";
                // Genera complemento Donatarias
                $divisas = new ComplementoDivisas($complemento->Divisas, $this->xml);
                $complementoElement->appendChild($divisas->GeneraComplemento());
            }
            // Genera complemento de ImpuestosLocales
            if ($complemento->ImpuestosLocales != null && !empty($complemento->ImpuestosLocales)) {
                // Agrega el namespace
                $xmlns = $this->xml->createAttribute("xmlns:implocal");
                $xmlns->value = "http://www.sat.gob.mx/implocal";
                $this->cfdiElement->appendChild($xmlns);
                // Agrega Schema
                $this->schemaLocation = $this->schemaLocation . " http://www.sat.gob.mx/implocal http://www.sat.gob.mx/sitio_internet/cfd/implocal/implocal.xsd";
                // Genera complemento Donatarias
                $impLoc = new ComplementoImpLocal($complemento->ImpuestosLocales, $this->xml);
                $complementoElement->appendChild($impLoc->GeneraComplemento());
            }
            // Genera complemento de Leyendas Fiscales
            if ($complemento->LeyendasFiscales != null && !empty($complemento->LeyendasFiscales)) {
                // Agrega el namespace
                $xmlns = $this->xml->createAttribute("xmlns:leyendasFisc");
                $xmlns->value = "http://www.sat.gob.mx/leyendasFiscales";
                $this->cfdiElement->appendChild($xmlns);
                // Agrega Schema
                $this->schemaLocation = $this->schemaLocation . " http://www.sat.gob.mx/leyendasFiscales http://www.sat.gob.mx/sitio_internet/cfd/leyendasFiscales/leyendasFisc.xsd";
                // Genera complemento Leyendas Fiscales
                $leyFis = new ComplementoLeyendasFiscales($complemento->LeyendasFiscales, $this->xml);
                $complementoElement->appendChild($leyFis->GeneraComplemento());
            }
            // Genera complemento de Persona física integrante de coordinado
            if ($complemento->PFintegranteCoordinado != null && !empty($complemento->PFintegranteCoordinado)) {
                // Agrega el namespace
                $xmlns = $this->xml->createAttribute("xmlns:pfic");
                $xmlns->value = "http://www.sat.gob.mx/pfic";
                $this->cfdiElement->appendChild($xmlns);
                // Agrega Schema
                $this->schemaLocation = $this->schemaLocation . " http://www.sat.gob.mx/pfic http://www.sat.gob.mx/sitio_internet/cfd/pfic/pfic.xsd";
                // Genera complemento Persona física integrante de coordinado
                $pfInt = new ComplementoPFintCoor($complemento->PFintegranteCoordinado, $this->xml);
                $complementoElement->appendChild($pfInt->GeneraComplemento());
            }
            // Genera complemento de Turista pasajero extranjero
            if ($complemento->TuristaPasajeroExtranjero != null && !empty($complemento->TuristaPasajeroExtranjero)) {
                // Agrega el namespace
                $xmlns = $this->xml->createAttribute("xmlns:tpe");
                $xmlns->value = "http://www.sat.gob.mx/TuristaPasajeroExtranjero";
                $this->cfdiElement->appendChild($xmlns);
                // Agrega Schema
                $this->schemaLocation = $this->schemaLocation . " http://www.sat.gob.mx/TuristaPasajeroExtranjero http://www.sat.gob.mx/sitio_internet/cfd/TuristaPasajeroExtranjero/TuristaPasajeroExtranjero.xsd";
                // Genera complemento Turista pasajero extranjero
                $tpe = new ComplementoTuristaPasajeroExt($complemento->TuristaPasajeroExtranjero, $this->xml);
                $complementoElement->appendChild($tpe->GeneraComplemento());
            }
            // Genera complemento de Spei de tercero a tercero.
            if ($complemento->Complemento_SPEI != null && !empty($complemento->Complemento_SPEI)) {
                // Agrega el namespace
                $xmlns = $this->xml->createAttribute("xmlns:spei");
                $xmlns->value = "http://www.sat.gob.mx/spei";
                $this->cfdiElement->appendChild($xmlns);
                // Agrega Schema
                $this->schemaLocation = $this->schemaLocation . " http://www.sat.gob.mx/spei http://www.sat.gob.mx/sitio_internet/cfd/spei/spei.xsd";
                // Genera complemento Turista pasajero extranjero
                $spei = new ComplementoSPEITerceros($complemento->Complemento_SPEI, $this->xml);
                $complementoElement->appendChild($spei->GeneraComplemento());
            }
            // Agrega el complemento al comprobante
            $this->cfdiElement->appendChild($complementoElement);
        }
    }

    /**
     * Genera cadena original del comprobante
     */
    private function generaCadenaOriginal()
    {
        // Genera el para obetener su cadena original
        $this->generaSchemaLocation();
        $this->xml->appendChild($this->cfdiElement);
        $this->xml->formatOutput = true;
        // Agrega el XML
        $this->cadenaOriginal = $this->utlXml->GeneraCadenaOriginal($this->xml->saveXML());
    }

    /**
     * Genera sello del certificado y numero de certificado
     */
    private function generaSelloCert()
    {
        // LLama procesos de sellado, certificado y numero de certificado
        $this->sello = $this->utlXml->GeneralSelloCfdi33($this->cadenaOriginal, file_get_contents($this->rutaKey), $this->claveKey);
        //Agrega Sello al XML
        if ($this->sello != null && !empty($this->sello)) {
            $Sello = $this->xml->createAttribute('Sello');
            $Sello->value = $this->sello;
            $this->cfdiElement->appendChild($Sello);
        }
    }

    /**
     * General el XML final
     * @return type
     */
    public function getXml()
    {
        $this->certificado = $this->utlCert->GeneraCertificado2Pem(file_get_contents($this->rutaCert));
        $this->noCertificado = $this->utlCert->GetNumCertificado(file_get_contents($this->rutaCert));

        //Agrega Certificado al XML
        if ($this->certificado != null && !empty($this->certificado)) {
            $Certificado = $this->xml->createAttribute('Certificado');
            $Certificado->value = $this->certificado;
            $this->cfdiElement->appendChild($Certificado);
        }
        //Agrega No Certificado al XML
        if ($this->noCertificado != null && !empty($this->noCertificado)) {
            $NoCertificado = $this->xml->createAttribute('NoCertificado');
            $NoCertificado->value = $this->noCertificado;
            $this->cfdiElement->appendChild($NoCertificado);
        }

        $this->generaCadenaOriginal();
        $this->generaSchemaLocation();
        $this->generaSelloCert();
        $this->xml->appendChild($this->cfdiElement);
        $this->xml->formatOutput = true;
        return $this->xml->saveXML();
    }

    /**
     * Regresa valores adicionales como Cert, NoCert, Sello, Cadena Original
     * @return array()
     */
    public function getDatosAdicionales()
    {
        $valores['Certificado'] = $this->certificado;
        $valores['NoCertificado'] = $this->noCertificado;
        $valores['Sello'] = $this->sello;
        $valores['CadenaOriginal'] = $this->cadenaOriginal;
        $valores['Fecha'] = $this->fechaEmision;
        return $valores;
    }
}
