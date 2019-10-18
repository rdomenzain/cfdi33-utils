<?php

namespace rdomenzain\cfdi\utils\core\Complementos;

class ComplementoImpLocal
{
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $donatarias Donatarias */
    private $implocal;
    /* @var $complemento DOMElement */
    private $complemento;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($implocal, $xmlRoot)
    {
        $this->xmlRoot = $xmlRoot;
        $this->implocal = $implocal;
        $this->strXml = new StringUtils();
    }

    public function GeneraComplemento()
    {
        // Crea el complemento
        $this->complemento = $this->xmlRoot->createElement("implocal:ImpuestosLocales");
        // Agrega atributo version
        $version = $this->xmlRoot->createAttribute("version");
        $version->value = "1.0";
        $this->complemento->appendChild($version);
        // Agrega atributo Total de Retenciones
        if ($this->implocal->TotaldeRetenciones != null && !empty($this->implocal->TotaldeRetenciones)) {
            $TotaldeRetenciones = $this->xmlRoot->createAttribute("TotaldeRetenciones");
            $TotaldeRetenciones->value = $this->implocal->TotaldeRetenciones;
            $this->complemento->appendChild($TotaldeRetenciones);
        }
        // Agrega atributo Total de Traslados
        if ($this->implocal->TotaldeTraslados != null && !empty($this->implocal->TotaldeTraslados)) {
            $TotaldeTraslados = $this->xmlRoot->createAttribute("TotaldeTraslados");
            $TotaldeTraslados->value = $this->implocal->TotaldeTraslados;
            $this->complemento->appendChild($TotaldeTraslados);
        }
        // Genera los nodos de retenciones y traslados locales
        $this->GeneraRetTrasLocales();
        // Regresa el complemento
        return $this->complemento;
    }

    private function GeneraRetTrasLocales()
    {
        // Genera el nodo Retenciones locales
        if ($this->implocal->RetencionesLocales != null && count($this->implocal->RetencionesLocales) > 0) {
            foreach ($this->implocal->RetencionesLocales as $retLoc) {
                // Agrega nodo de Retenciones locales
                $elementRetLoc = $this->xmlRoot->createElement("implocal:RetencionesLocales");
                // Agrega atributo ImpLocRetenido
                $ImpLocRetenido = $this->xmlRoot->createAttribute("ImpLocRetenido");
                $ImpLocRetenido->value = $this->strXml->replaceEcodeUt8($retLoc->ImpLocRetenido);
                $elementRetLoc->appendChild($ImpLocRetenido);
                // Agrega atributo ImpLocRetenido
                $TasadeRetencion = $this->xmlRoot->createAttribute("TasadeRetencion");
                $TasadeRetencion->value = $retLoc->TasadeRetencion;
                $elementRetLoc->appendChild($TasadeRetencion);
                // Agrega atributo ImpLocRetenido
                $Importe = $this->xmlRoot->createAttribute("Importe");
                $Importe->value = $retLoc->Importe;
                $elementRetLoc->appendChild($Importe);
                // Lo agrega al nodo principal
                $this->complemento->appendChild($elementRetLoc);
            }
        }
        // Genera el nodo de Traslados Locales
        if ($this->implocal->TrasladosLocales != null && count($this->implocal->TrasladosLocales) > 0) {
            foreach ($this->implocal->TrasladosLocales as $traLoc) {
                // Agrega nodo de Retenciones locales
                $elementTraLoc = $this->xmlRoot->createElement("implocal:TrasladosLocales");
                // Agrega atributo ImpLocTrasladado
                $ImpLocTrasladado = $this->xmlRoot->createAttribute("ImpLocTrasladado");
                $ImpLocTrasladado->value = $this->strXml->replaceEcodeUt8($traLoc->ImpLocTrasladado);
                $elementTraLoc->appendChild($ImpLocTrasladado);
                // Agrega atributo TasadeTraslado
                $TasadeTraslado = $this->xmlRoot->createAttribute("TasadeTraslado");
                $TasadeTraslado->value = $traLoc->TasadeTraslado;
                $elementTraLoc->appendChild($TasadeTraslado);
                // Agrega atributo ImpLocRetenido
                $Importe = $this->xmlRoot->createAttribute("Importe");
                $Importe->value = $traLoc->Importe;
                $elementTraLoc->appendChild($Importe);
                // Lo agrega al nodo principal
                $this->complemento->appendChild($elementTraLoc);
            }
        }
    }
}
