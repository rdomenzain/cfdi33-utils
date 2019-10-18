<?php

namespace rdomenzain\cfdi\utils\core;

class NodeConceptos
{

    /* @var $conceptos Conceptos */
    private $conceptos;
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;

    function __construct($conceptos, $xmlRoot)
    {
        $this->conceptos = $conceptos;
        $this->xmlRoot = $xmlRoot;
    }

    public function GeneraNodo()
    {
        if ($this->conceptos != null && count($this->conceptos) > 0) {
            $conceptosElement = $this->xmlRoot->createElement("cfdi:Conceptos");
            foreach ($this->conceptos->Concepto as $concept) {
                // Agrega Clave Prov Serv
                $conceptoElement = $this->xmlRoot->createElement("cfdi:Concepto");
                // Agrega atributo ClaveProdServ
                $ClaveProdServ = $this->xmlRoot->createAttribute("ClaveProdServ");
                $ClaveProdServ->value = $concept->ClaveProdServ;
                $conceptoElement->appendChild($ClaveProdServ);
                // Agrega atributo No Identificacion
                if ($concept->NoIdentificacion  != null && !empty($concept->NoIdentificacion)) {
                    $NoIdentificacion = $this->xmlRoot->createAttribute("NoIdentificacion");
                    $NoIdentificacion->value = $concept->NoIdentificacion;
                    $conceptoElement->appendChild($NoIdentificacion);
                }
                // Agrega atributo Cantidad
                $Cantidad = $this->xmlRoot->createAttribute("Cantidad");
                $Cantidad->value = $concept->Cantidad;
                $conceptoElement->appendChild($Cantidad);
                // Agrega atributo Clave Unidad
                $ClaveUnidad = $this->xmlRoot->createAttribute("ClaveUnidad");
                $ClaveUnidad->value = $concept->ClaveUnidad;
                $conceptoElement->appendChild($ClaveUnidad);
                // Agrega Unidad
                if ($concept->Unidad  != null && !empty($concept->Unidad)) {
                    $Unidad = $this->xmlRoot->createAttribute("Unidad");
                    $Unidad->value = $concept->Unidad;
                    $conceptoElement->appendChild($Unidad);
                }
                // Agrega atributo Descripcion
                $Descripcion = $this->xmlRoot->createAttribute("Descripcion");
                $Descripcion->value = $concept->Descripcion;
                $conceptoElement->appendChild($Descripcion);
                // Agrega atributo ValorUnitario
                $ValorUnitario = $this->xmlRoot->createAttribute("ValorUnitario");
                $ValorUnitario->value = $concept->ValorUnitario;
                $conceptoElement->appendChild($ValorUnitario);
                // Agrega atributo Importe
                $Importe = $this->xmlRoot->createAttribute("Importe");
                $Importe->value = $concept->Importe;
                $conceptoElement->appendChild($Importe);
                // Agrega Descuento
                if ($concept->Descuento  != null && !empty($concept->Descuento)) {
                    $Descuento = $this->xmlRoot->createAttribute("Descuento");
                    $Descuento->value = $concept->Descuento;
                    $conceptoElement->appendChild($Descuento);
                }
                // Agrega el nodo Impuestos a Concepto
                $nodoImpuesto = $this->generaNodoImpuestos($concept);
                if ($nodoImpuesto != null) {
                    $conceptoElement->appendChild($nodoImpuesto);
                }
                // Agrega el nodo de Informacion Aduanera
                $nodoInfoAduanera = $this->generaNodoInfoAduanera($concept);
                if ($nodoInfoAduanera != null) {
                    $conceptoElement->appendChild($nodoInfoAduanera);
                }
                // Agrega el nodo de Cuenta Predial
                $nodoCtaPredial = $this->generaNodoCtaPredial($concept);
                if ($nodoCtaPredial != null) {
                    $conceptoElement->appendChild($nodoCtaPredial);
                }
                // Agrega el nodo de Parte
                $nodoParte = $this->generaNodoParte($concept);
                if ($nodoParte != null) {
                    $conceptoElement->appendChild($nodoParte);
                }
                // Agrega el nodo Concepto a Conceptos
                $conceptosElement->appendChild($conceptoElement);
            }
            return $conceptosElement;
        } else {
            return null;
        }
    }

    private function generaNodoImpuestos($concepto)
    {
        /* @var $Impuestos Impuestos */
        $Impuestos = $concepto->Impuestos;
        if ($Impuestos != null && count($Impuestos) > 0) {
            // Agrega nodo de Impuestos
            $impuestosElement = $this->xmlRoot->createElement("cfdi:Impuestos");
            // Agrega nodo si existe de traslados
            $Traslados = $Impuestos->Traslados;
            if ($Traslados != null && count($Traslados) > 0) {
                $trasladosElement = $this->xmlRoot->createElement("cfdi:Traslados");
                foreach ($Traslados->Traslado as $oneTras) {
                    // Agrega nodo de traslado
                    $trasElement = $this->xmlRoot->createElement("cfdi:Traslado");
                    // Agrega atributo de Base
                    $Base = $this->xmlRoot->createAttribute("Base");
                    $Base->value = $oneTras->Base;
                    $trasElement->appendChild($Base);
                    // Agrega atributo de Impuesto
                    $Impuesto = $this->xmlRoot->createAttribute("Impuesto");
                    $Impuesto->value = $oneTras->Impuesto;
                    $trasElement->appendChild($Impuesto);
                    // Agrega atributo de TipoFactor
                    $TipoFactor = $this->xmlRoot->createAttribute("TipoFactor");
                    $TipoFactor->value = $oneTras->TipoFactor;
                    $trasElement->appendChild($TipoFactor);
                    // Agrega atributo de TasaOCuota
                    if ($oneTras->TasaOCuota != null && !empty($oneTras->TasaOCuota)) {
                        $TasaOCuota = $this->xmlRoot->createAttribute("TasaOCuota");
                        $TasaOCuota->value = $oneTras->TasaOCuota;
                        $trasElement->appendChild($TasaOCuota);
                    }
                    // Agrega atributo de Importe
                    if ($oneTras->Importe != null && !empty($oneTras->Importe)) {
                        $Importe = $this->xmlRoot->createAttribute("Importe");
                        $Importe->value = $oneTras->Importe;
                        $trasElement->appendChild($Importe);
                    }
                    $trasladosElement->appendChild($trasElement);
                }
                $impuestosElement->appendChild($trasladosElement);
            }
            // Agrega nodo de Retenciones
            $Retenciones = $Impuestos->Retenciones;
            if ($Retenciones != null && count($Retenciones) > 0) {
                $retencionesElement = $this->xmlRoot->createElement("cfdi:Retenciones");
                foreach ($Retenciones->Retencion as $oneRet) {
                    // Agrega nodo de traslado
                    $retElement = $this->xmlRoot->createElement("cfdi:Retencion");
                    // Agrega atributo de Base
                    $Base = $this->xmlRoot->createAttribute("Base");
                    $Base->value = $oneRet->Base;
                    $retElement->appendChild($Base);
                    // Agrega atributo de Impuesto
                    $Impuesto = $this->xmlRoot->createAttribute("Impuesto");
                    $Impuesto->value = $oneRet->Impuesto;
                    $retElement->appendChild($Impuesto);
                    // Agrega atributo de TipoFactor
                    $TipoFactor = $this->xmlRoot->createAttribute("TipoFactor");
                    $TipoFactor->value = $oneRet->TipoFactor;
                    $retElement->appendChild($TipoFactor);
                    // Agrega atributo de TasaOCuota
                    $TasaOCuota = $this->xmlRoot->createAttribute("TasaOCuota");
                    $TasaOCuota->value = $oneRet->TasaOCuota;
                    $retElement->appendChild($TasaOCuota);
                    // Agrega atributo de Importe
                    $Importe = $this->xmlRoot->createAttribute("Importe");
                    $Importe->value = $oneRet->Importe;
                    $retElement->appendChild($Importe);
                    // Agrega a nodo principal
                    $retencionesElement->appendChild($retElement);
                }
                $impuestosElement->appendChild($retencionesElement);
            }

            return $impuestosElement;
        } else {
            return null;
        }
    }

    private function generaNodoInfoAduanera($concepto)
    {
        $infoAduanera = $concepto->InformacionAduanera;
        if ($infoAduanera != null && !empty($infoAduanera)) {
            if ($infoAduanera->NumeroPedimento != null && !empty($infoAduanera->NumeroPedimento)) {
                // Agrega nodo de Informacion Aduanera
                $infoAduElement = $this->xmlRoot->createElement("cfdi:InformacionAduanera");
                // Agrega atributo Numero de Pedimento
                $NumeroPedimento = $this->xmlRoot->createAttribute("NumeroPedimento");
                $NumeroPedimento->value = $infoAduanera->NumeroPedimento;
                $infoAduElement->appendChild($NumeroPedimento);

                return $infoAduElement;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    private function generaNodoCtaPredial($concepto)
    {
        $ctaPredial = $concepto->CuentaPredial;
        if ($ctaPredial != null && !empty($ctaPredial)) {
            if ($ctaPredial->Numero != null && !empty($ctaPredial->Numero)) {
                // Agrega nodo de Informacion Aduanera
                $ctaPredialElement = $this->xmlRoot->createElement("cfdi:CuentaPredial");
                // Agrega atributo Numero de Pedimento
                $Numero = $this->xmlRoot->createAttribute("Numero");
                $Numero->value = $ctaPredial->Numero;
                $ctaPredialElement->appendChild($Numero);

                return $ctaPredialElement;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    private function generaComplementoConcepto($concepto)
    { }

    private function generaNodoParte($concepto)
    {
        $parte = $concepto->Parte;
        if ($parte != null && !empty($parte)) {
            // Agrega elemento de Parte
            $parteElement = $this->xmlRoot->createElement("cfdi:Parte");
            //Agrega atributo ClaveProdServ
            $ClaveProdServ = $this->xmlRoot->createAttribute("ClaveProdServ");
            $ClaveProdServ->value = $parte->ClaveProdServ;
            $parteElement->appendChild($ClaveProdServ);
            //Agrega atributo de NoIdentificacion
            if ($parte->NoIdentificacion != null && !empty($parte->NoIdentificacion)) {
                $NoIdentificacion = $this->xmlRoot->createAttribute("NoIdentificacion");
                $NoIdentificacion->value = $parte->NoIdentificacion;
                $parteElement->appendChild($NoIdentificacion);
            }
            //Agrega atributo Cantidad
            $Cantidad = $this->xmlRoot->createAttribute("Cantidad");
            $Cantidad->value = $parte->Cantidad;
            $parteElement->appendChild($Cantidad);
            //Agrega atributo de Unidad
            if ($parte->Unidad != null && !empty($parte->Unidad)) {
                $Unidad = $this->xmlRoot->createAttribute("Unidad");
                $Unidad->value = $parte->Unidad;
                $parteElement->appendChild($Unidad);
            }
            //Agrega atributo Descripcion
            $Descripcion = $this->xmlRoot->createAttribute("Descripcion");
            $Descripcion->value = $parte->Descripcion;
            $parteElement->appendChild($Descripcion);
            //Agrega atributo de ValorUnitario
            if ($parte->ValorUnitario != null && !empty($parte->ValorUnitario)) {
                $ValorUnitario = $this->xmlRoot->createAttribute("ValorUnitario");
                $ValorUnitario->value = $parte->ValorUnitario;
                $parteElement->appendChild($ValorUnitario);
            }
            //Agrega atributo de ValorUnitario
            if ($parte->Importe != null && !empty($parte->Importe)) {
                $Importe = $this->xmlRoot->createAttribute("Importe");
                $Importe->value = $parte->Importe;
                $parteElement->appendChild($Importe);
            }
            // Agrega el nodo de Informacion Aduanera
            $nodoInfoAduanera = $this->generaNodoInfoAduanera($parte);
            if ($nodoInfoAduanera != null) {
                $parteElement->appendChild($nodoInfoAduanera);
            }

            return $parteElement;
        } else {
            return null;
        }
    }
}
