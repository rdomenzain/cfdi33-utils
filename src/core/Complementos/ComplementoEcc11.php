<?php

namespace rdomenzain\cfdi\utils\core\Complementos;

class ComplementoEcc11
{
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $ecc11 EstadoDeCuentaCombustible */
    private $ecc11;
    /* @var $complemento DOMElement */
    private $complemento;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($ecc11, $xmlRoot)
    {
        $this->xmlRoot = $xmlRoot;
        $this->ecc11 = $ecc11;
        $this->strXml = new StringUtils();
    }

    private function ComplementoInicializa()
    {
        // Crea complemento
        $this->complemento = $this->xmlRoot->createElement("ecc11:EstadoDeCuentaCombustible");
        // Agrega valores ecc11
        $ecc11 = $this->xmlRoot->createAttribute("xmlns:ecc11");
        $ecc11->value = "http://www.sat.gob.mx/EstadoDeCuentaCombustible";
        $this->complemento->appendChild($ecc11);
        // Agrega valores Schema Location
        $schemaLocation = $this->xmlRoot->createAttribute("xsi:schemaLocation");
        $schemaLocation->value = "http://www.sat.gob.mx/EstadoDeCuentaCombustible http://www.sat.gob.mx/sitio_internet/cfd/EstadoDeCuentaCombustible/ecc11.xsd";
        $this->complemento->appendChild($schemaLocation);
        // Agrega valores XSI
        $xsi = $this->xmlRoot->createAttribute("xmlns:xsi");
        $xsi->value = "http://www.w3.org/2001/XMLSchema-instance";
        $this->complemento->appendChild($xsi);
    }

    public function GeneraComplemento()
    {
        // Inicializa el complemento
        $this->ComplementoInicializa();
        // Agrega atributo Version
        $Version = $this->xmlRoot->createAttribute("Version");
        $Version->value = "1.1";
        $this->complemento->appendChild($Version);
        // Agrega atributo TipoOperacion
        $TipoOperacion = $this->xmlRoot->createAttribute("TipoOperacion");
        $TipoOperacion->value = $this->strXml->replaceEcodeUt8($this->ecc11->TipoOperacion);
        $this->complemento->appendChild($TipoOperacion);
        // Agrega atributo NumeroDeCuenta
        $NumeroDeCuenta = $this->xmlRoot->createAttribute("NumeroDeCuenta");
        $NumeroDeCuenta->value = $this->strXml->replaceEcodeUt8($this->ecc11->NumeroDeCuenta);
        $this->complemento->appendChild($NumeroDeCuenta);
        // Agrega atributo SubTotal
        $SubTotal = $this->xmlRoot->createAttribute("SubTotal");
        $SubTotal->value = $this->ecc11->SubTotal;
        $this->complemento->appendChild($SubTotal);
        // Agrega atributo Total
        $Total = $this->xmlRoot->createAttribute("Total");
        $Total->value = $this->ecc11->Total;
        $this->complemento->appendChild($Total);
        // Agrega nodo de conceptos
        $conceptosVal = $this->GeneraConceptos();
        if ($conceptosVal != null) {
            $this->complemento->appendChild($conceptosVal);
        }
        return $this->complemento;
    }

    private function GeneraConceptos()
    {
        if ($this->ecc11->ConceptosECC != null && count($this->ecc11->ConceptosECC) > 0) {
            // Crea elemento de Conceptos
            $conceptoElement = $this->xmlRoot->createElement("ecc11:Conceptos");
            // Agrega los conceptos de estado de cuenta
            foreach ($this->ecc11->ConceptosECC as $concep) {
                // Crea elemento ConceptoEstadoDeCuentaCombustible
                $conEdoElement = $this->xmlRoot->createElement("ecc11:ConceptoEstadoDeCuentaCombustible");
                // Agrega atributo Identificador
                if ($concep->Identificador != null && !empty($concep->Identificador)) {
                    $Identificador = $this->xmlRoot->createAttribute("Identificador");
                    $Identificador->value = $this->strXml->replaceEcodeUt8($concep->Identificador);
                    $conEdoElement->appendChild($Identificador);
                }
                // Agrega atributo Fecha
                $Fecha = $this->xmlRoot->createAttribute("Fecha");
                $Fecha->value = $this->strXml->getFechaActualCFDI();
                $conEdoElement->appendChild($Fecha);
                // Agrega atributo RFC
                if ($concep->Rfc != null && !empty($concep->Rfc)) {
                    $Rfc = $this->xmlRoot->createAttribute("Rfc");
                    $Rfc->value = $this->strXml->replaceEcodeUt8($concep->Rfc);
                    $conEdoElement->appendChild($Rfc);
                }
                // Agrega atributo ClaveEstacion
                if ($concep->ClaveEstacion != null && !empty($concep->ClaveEstacion)) {
                    $ClaveEstacion = $this->xmlRoot->createAttribute("ClaveEstacion");
                    $ClaveEstacion->value = $this->strXml->replaceEcodeUt8($concep->ClaveEstacion);
                    $conEdoElement->appendChild($ClaveEstacion);
                }
                // Agrega atributo TAR
                $TAR = $this->xmlRoot->createAttribute("TAR");
                $TAR->value = $concep->TAR;
                $conEdoElement->appendChild($TAR);
                // Agrega atributo Cantidad
                if ($concep->Cantidad != null && !empty($concep->Cantidad)) {
                    $Cantidad = $this->xmlRoot->createAttribute("Cantidad");
                    $Cantidad->value = $concep->Cantidad;
                    $conEdoElement->appendChild($Cantidad);
                }
                // Agrega atributo NoIdentificacion
                if ($concep->NoIdentificacion != null && !empty($concep->NoIdentificacion)) {
                    $NoIdentificacion = $this->xmlRoot->createAttribute("NoIdentificacion");
                    $NoIdentificacion->value = $concep->NoIdentificacion;
                    $conEdoElement->appendChild($NoIdentificacion);
                }
                // Agrega atributo Unidad
                $Unidad = $this->xmlRoot->createAttribute("Unidad");
                $Unidad->value = $concep->Unidad;
                $conEdoElement->appendChild($Unidad);
                // Agrega atributo NombreCombustible
                if ($concep->NombreCombustible != null && !empty($concep->NombreCombustible)) {
                    $NombreCombustible = $this->xmlRoot->createAttribute("NombreCombustible");
                    $NombreCombustible->value = $this->strXml->replaceEcodeUt8($concep->NombreCombustible);
                    $conEdoElement->appendChild($NombreCombustible);
                }
                // Agrega atributo FolioOperacion
                if ($concep->FolioOperacion != null && !empty($concep->FolioOperacion)) {
                    $FolioOperacion = $this->xmlRoot->createAttribute("FolioOperacion");
                    $FolioOperacion->value = $this->strXml->replaceEcodeUt8($concep->FolioOperacion);
                    $conEdoElement->appendChild($FolioOperacion);
                }
                // Agrega atributo ValorUnitario
                if ($concep->ValorUnitario != null && !empty($concep->ValorUnitario)) {
                    $ValorUnitario = $this->xmlRoot->createAttribute("ValorUnitario");
                    $ValorUnitario->value = $concep->ValorUnitario;
                    $conEdoElement->appendChild($ValorUnitario);
                }
                // Agrega atributo Importe
                if ($concep->Importe != null && !empty($concep->Importe)) {
                    $Importe = $this->xmlRoot->createAttribute("Importe");
                    $Importe->value = $concep->Importe;
                    $conEdoElement->appendChild($Importe);
                }
                // Agrega nodo de traslados
                if ($concep->TrasladosECC != null && count($concep->TrasladosECC) > 0) {
                    // Agrega elemento de traslados
                    $trasladosElement = $this->xmlRoot->createElement("ecc11:Traslados");
                    foreach ($concep->TrasladosECC as $tras) {
                        // Agrega elemento traslado
                        $trasElemen = $this->xmlRoot->createElement("ecc11:Traslado");
                        // Agrega atributo Impuesto
                        if ($tras->Impuesto != null && !empty($tras->Impuesto)) {
                            $Impuesto = $this->xmlRoot->createAttribute("Impuesto");
                            $Impuesto->value = $tras->Impuesto;
                            $trasElemen->appendChild($Impuesto);
                        }
                        // Agrega atributo TasaoCuota
                        if ($tras->TasaoCuota != null && !empty($tras->TasaoCuota)) {
                            $TasaoCuota = $this->xmlRoot->createAttribute("TasaoCuota");
                            $TasaoCuota->value = $tras->TasaoCuota;
                            $trasElemen->appendChild($TasaoCuota);
                        }
                        // Agrega atributo Importe
                        if ($tras->Importe != null && !empty($tras->Importe)) {
                            $Importe = $this->xmlRoot->createAttribute("Importe");
                            $Importe->value = $tras->Importe;
                            $trasElemen->appendChild($Importe);
                        }
                        $trasladosElement->appendChild($trasElemen);
                    }
                    $conEdoElement->appendChild($trasladosElement);
                }
                $conceptoElement->appendChild($conEdoElement);
            }
            return $conceptoElement;
        } else {
            return null;
        }
    }
}
