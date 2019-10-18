<?php

namespace rdomenzain\cfdi\utils\core\Complementos;

class ComplementoDonatarias
{
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $donatarias Donatarias */
    private $donatarias;
    /* @var $complemento DOMElement */
    private $complemento;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($donatarias, $xmlRoot)
    {
        $this->xmlRoot = $xmlRoot;
        $this->donatarias = $donatarias;
        $this->strXml = new StringUtils();
    }

    public function GeneraComplemento()
    {
        // Crea el complemento
        $this->complemento = $this->xmlRoot->createElement("donat:Donatarias");
        // Agrega el xmlns
        $xmlns = $this->xmlRoot->createAttribute("xmlns:donat");
        $xmlns->value = "http://www.sat.gob.mx/donat";
        $this->complemento->appendChild($xmlns);
        // Agrega atributo version
        $version = $this->xmlRoot->createAttribute("version");
        $version->value = "1.1";
        $this->complemento->appendChild($version);
        // Agrega atributo No Autorizacion
        if ($this->donatarias->noAutorizacion != null && !empty($this->donatarias->noAutorizacion)) {
            $noAutorizacion = $this->xmlRoot->createAttribute("noAutorizacion");
            $noAutorizacion->value = $this->strXml->replaceEcodeUt8($this->donatarias->noAutorizacion);
            $this->complemento->appendChild($noAutorizacion);
        }
        // Agrega atributo Fecha Autorizacion
        if ($this->donatarias->fechaAutorizacion != null && !empty($this->donatarias->fechaAutorizacion)) {
            $fechaAutorizacion = $this->xmlRoot->createAttribute("fechaAutorizacion");
            $fechaAutorizacion->value = $this->donatarias->fechaAutorizacion;
            $this->complemento->appendChild($fechaAutorizacion);
        }
        // Agrega atributo leyenda
        if ($this->donatarias->leyenda != null && !empty($this->donatarias->leyenda)) {
            $leyenda = $this->xmlRoot->createAttribute("leyenda");
            $leyenda->value = $this->strXml->replaceEcodeUt8($this->donatarias->leyenda);
            $this->complemento->appendChild($leyenda);
        }

        return $this->complemento;
    }
}
