<?php

namespace rdomenzain\cfdi\utils\core\Complementos;

class ComplementoTuristaPasajeroExt
{
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $tpe TuristaPasajeroExtranjero */
    private $tpe;
    /* @var $complemento DOMElement */
    private $complemento;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($tpe, $xmlRoot)
    {
        $this->xmlRoot = $xmlRoot;
        $this->tpe = $tpe;
        $this->strXml = new StringUtils();
    }

    public function GeneraComplemento()
    {
        // Crea el complemento
        $this->complemento = $this->xmlRoot->createElement("tpe:TuristaPasajeroExtranjero");
        // Agrega atributo version
        $version = $this->xmlRoot->createAttribute("version");
        $version->value = "1.0";
        $this->complemento->appendChild($version);
        // Agrega atributo Fecha de transito
        $fechadeTransito = $this->xmlRoot->createAttribute("fechadeTransito");
        $fechadeTransito->value = $this->strXml->getFechaISO8601($this->tpe->fechadeTransito);
        $this->complemento->appendChild($fechadeTransito);
        // Agrega atributo Tipo de Transito
        $tipoTransito = $this->xmlRoot->createAttribute("tipoTransito");
        $tipoTransito->value = $this->strXml->replaceEcodeUt8($this->tpe->tipoTransito);
        $this->complemento->appendChild($tipoTransito);
        // Genera Nodo de Datos de Transito
        $this->GeneraDatosTransito();
        return $this->complemento;
    }

    private function GeneraDatosTransito()
    {
        // Genera el nodo de DatosTransito
        if ($this->tpe->datosTransito != null) {
            // Agrega nodo de Retenciones locales
            $elementDatosTransito = $this->xmlRoot->createElement("tpe:datosTransito");
            // Agrega atributo Via
            $Via = $this->xmlRoot->createAttribute("Via");
            $Via->value = $this->strXml->replaceEcodeUt8($this->tpe->datosTransito->Via);
            $elementDatosTransito->appendChild($Via);
            // Agrega atributo TipoId
            $TipoId = $this->xmlRoot->createAttribute("TipoId");
            $TipoId->value = $this->strXml->replaceEcodeUt8($this->tpe->datosTransito->TipoId);
            $elementDatosTransito->appendChild($TipoId);
            // Agrega atributo NumeroId
            $NumeroId = $this->xmlRoot->createAttribute("NumeroId");
            $NumeroId->value = $this->strXml->replaceEcodeUt8($this->tpe->datosTransito->NumeroId);
            $elementDatosTransito->appendChild($NumeroId);
            // Agrega atributo Nacionalidad
            $Nacionalidad = $this->xmlRoot->createAttribute("Nacionalidad");
            $Nacionalidad->value = $this->strXml->replaceEcodeUt8($this->tpe->datosTransito->Nacionalidad);
            $elementDatosTransito->appendChild($Nacionalidad);
            // Agrega atributo EmpresaTransporte
            $EmpresaTransporte = $this->xmlRoot->createAttribute("EmpresaTransporte");
            $EmpresaTransporte->value = $this->strXml->replaceEcodeUt8($this->tpe->datosTransito->EmpresaTransporte);
            $elementDatosTransito->appendChild($EmpresaTransporte);
            // Agrega atributo IdTransporte
            if ($this->tpe->datosTransito->IdTransporte != null && !empty($this->tpe->datosTransito->IdTransporte)) {
                $IdTransporte = $this->xmlRoot->createAttribute("IdTransporte");
                $IdTransporte->value = $this->strXml->replaceEcodeUt8($this->tpe->datosTransito->IdTransporte);
                $elementDatosTransito->appendChild($IdTransporte);
            }
            // Lo agrega al nodo principal
            $this->complemento->appendChild($elementDatosTransito);
        }
    }
}
