<?php

namespace rdomenzain\cfdi\utils\core\Complementos;

class ComplementoPFintCoor
{
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $pfic PFintegranteCoordinado */
    private $pfic;
    /* @var $complemento DOMElement */
    private $complemento;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($pfic, $xmlRoot)
    {
        $this->xmlRoot = $xmlRoot;
        $this->pfic = $pfic;
        $this->strXml = new StringUtils();
    }

    public function GeneraComplemento()
    {
        // Crea el complemento
        $this->complemento = $this->xmlRoot->createElement("pfic:PFintegranteCoordinado");
        // Agrega atributo version
        $version = $this->xmlRoot->createAttribute("version");
        $version->value = "1.0";
        $this->complemento->appendChild($version);
        // Agrega atributo Clave Vehicular
        $ClaveVehicular = $this->xmlRoot->createAttribute("ClaveVehicular");
        $ClaveVehicular->value = $this->strXml->replaceEcodeUt8($this->pfic->ClaveVehicular);
        $this->complemento->appendChild($ClaveVehicular);
        // Agrega atributo Placa
        $Placa = $this->xmlRoot->createAttribute("Placa");
        $Placa->value = $this->strXml->replaceEcodeUt8($this->pfic->Placa);
        $this->complemento->appendChild($Placa);
        // Agrega atributo RFCPF
        if ($this->pfic->RFCPF != null && !empty($this->pfic->RFCPF)) {
            $RFCPF = $this->xmlRoot->createAttribute("RFCPF");
            $RFCPF->value = $this->strXml->replaceEcodeUt8($this->pfic->RFCPF);
            $this->complemento->appendChild($RFCPF);
        }
        return $this->complemento;
    }
}
