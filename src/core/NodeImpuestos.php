<?php

namespace rdomenzain\cfdi\utils\core;

class NodeImpuestos
{
    /* @var $impuestos ImpImpuestos */
    private $impuestos;
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;

    function __construct($impuestos, $xmlRoot)
    {
        $this->impuestos = $impuestos;
        $this->xmlRoot = $xmlRoot;
    }

    public function GeneraNodo()
    {
        $impuestos = $this->impuestos;
        if ($impuestos != null) {
            // Agrega nodo Impuestos
            $elementImpuestos = $this->xmlRoot->createElement("cfdi:Impuestos");
            // Agrega atributo Total Impuestos Retenido
            if ($impuestos->TotalImpuestosRetenidos != null && !empty($impuestos->TotalImpuestosRetenidos)) {
                if ($impuestos->TotalImpuestosRetenidos > 0) {
                    $TotalImpuestosRetenidos = $this->xmlRoot->createAttribute("TotalImpuestosRetenidos");
                    $TotalImpuestosRetenidos->value = $impuestos->TotalImpuestosRetenidos;
                    $elementImpuestos->appendChild($TotalImpuestosRetenidos);
                }
            }
            // Agrega atributo Total Impuestos Trasladados
            if ($impuestos->TotalImpuestosTrasladados != null && !empty($impuestos->TotalImpuestosTrasladados)) {
                if ($impuestos->TotalImpuestosTrasladados > 0) {
                    $TotalImpuestosTrasladados = $this->xmlRoot->createAttribute("TotalImpuestosTrasladados");
                    $TotalImpuestosTrasladados->value = $impuestos->TotalImpuestosTrasladados;
                    $elementImpuestos->appendChild($TotalImpuestosTrasladados);
                }
            }
            // Agrega Nodo de Retenciones
            if ($impuestos->Retenciones != null && count($impuestos->Retenciones) > 0) {
                $elementRetenciones = $this->xmlRoot->createElement("cfdi:Retenciones");
                foreach ($impuestos->Retenciones->Retencion as $ret) {
                    // Agrega nodos de retencion
                    $elementRet = $this->xmlRoot->createElement("cfdi:Retencion");
                    //Agrega atributo de impuesto
                    if ($ret->Impuesto != null && !empty($ret->Impuesto)) {
                        $Impuesto = $this->xmlRoot->createAttribute("Impuesto");
                        $Impuesto->value = $ret->Impuesto;
                        $elementRet->appendChild($Impuesto);
                    }
                    //Agrega atributo de Importe
                    if ($ret->Importe != null && !empty($ret->Importe)) {
                        $Importe = $this->xmlRoot->createAttribute("Importe");
                        $Importe->value = $ret->Importe;
                        $elementRet->appendChild($Importe);
                    }
                    // Agrega nodo de Retencion a Retenciones
                    $elementRetenciones->appendChild($elementRet);
                }
                // Agrega nodo de Retenciones a nodo de Impuestos
                $elementImpuestos->appendChild($elementRetenciones);
            }
            // Agrega Nodo de Traslados
            if ($impuestos->Traslados != null && count($impuestos->Traslados->Traslado) > 0) {
                $elementTraslados = $this->xmlRoot->createElement("cfdi:Traslados");
                foreach ($impuestos->Traslados->Traslado as $tras) {
                    // Agrega nodos de retencion
                    $elementTra = $this->xmlRoot->createElement("cfdi:Traslado");
                    //Agrega atributo de impuesto
                    if ($tras->Impuesto != null && !empty($tras->Impuesto)) {
                        $Impuesto = $this->xmlRoot->createAttribute("Impuesto");
                        $Impuesto->value = $tras->Impuesto;
                        $elementTra->appendChild($Impuesto);
                    }
                    //Agrega atributo de Tipo Factor
                    if ($tras->TipoFactor != null && !empty($tras->TipoFactor)) {
                        $TipoFactor = $this->xmlRoot->createAttribute("TipoFactor");
                        $TipoFactor->value = $tras->TipoFactor;
                        $elementTra->appendChild($TipoFactor);
                    }
                    //Agrega atributo de Tasa o Cuota
                    if ($tras->TasaOCuota != null && !empty($tras->TasaOCuota)) {
                        $TasaOCuota = $this->xmlRoot->createAttribute("TasaOCuota");
                        $TasaOCuota->value = $tras->TasaOCuota;
                        $elementTra->appendChild($TasaOCuota);
                    }
                    //Agrega atributo de Importe
                    if ($tras->Importe != null && !empty($tras->Importe)) {
                        $Importe = $this->xmlRoot->createAttribute("Importe");
                        $Importe->value = $tras->Importe;
                        $elementTra->appendChild($Importe);
                    }
                    // Agrega el Traslado a nodo de traslados
                    $elementTraslados->appendChild($elementTra);
                }
                // Agrega nodo de traslados a nodo de Impuestos
                $elementImpuestos->appendChild($elementTraslados);
            }

            return $elementImpuestos;
        } else {
            return null;
        }
    }
}
