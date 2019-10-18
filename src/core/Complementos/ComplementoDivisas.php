<?php

namespace rdomenzain\cfdi\utils\core\Complementos;

class ComplementoDivisas
{
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $divisas Divisas */
    private $divisas;
    /* @var $complemento DOMElement */
    private $complemento;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($divisas, $xmlRoot)
    {
        $this->xmlRoot = $xmlRoot;
        $this->divisas = $divisas;
        $this->strXml = new StringUtils();
    }

    public function GeneraComplemento()
    {
        // Crea el complemento
        $this->complemento = $this->xmlRoot->createElement("divisas:Divisas");
        // Agrega atributo version
        $version = $this->xmlRoot->createAttribute("version");
        $version->value = "1.0";
        $this->complemento->appendChild($version);
        // Agrega atributo No Autorizacion
        $tipoOperacion = $this->xmlRoot->createAttribute("tipoOperacion");
        $tipoOperacion->value = $this->strXml->replaceEcodeUt8($this->divisas->tipoOperacion);
        $this->complemento->appendChild($tipoOperacion);

        return $this->complemento;
    }
}
