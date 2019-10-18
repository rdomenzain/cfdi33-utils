<?php

namespace rdomenzain\cfdi\utils\core;

use rdomenzain\cfdi\utils\utils\CommonsUtils;

class NodeEmisor
{
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $emisor Emisor */
    private $emisor;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($emisor, $xmlRoot)
    {
        $this->emisor = $emisor;
        $this->xmlRoot = $xmlRoot;
        $this->strXml = new CommonsUtils();
    }

    public function GeneraNodo()
    {
        if ($this->emisor != null) {
            // Crea elemento del emisor
            $emisorElemnt = $this->xmlRoot->createElement("cfdi:Emisor");
            // Agrega atributo de RFC
            $Rfc = $this->xmlRoot->createAttribute("Rfc");
            $Rfc->value = $this->strXml->ReplaceEncodeUtf8($this->emisor->Rfc);
            $emisorElemnt->appendChild($Rfc);
            //Agrega atributo de nombre
            if ($this->emisor->Nombre != null && !empty($this->emisor->Nombre)) {
                $Nombre = $this->xmlRoot->createAttribute("Nombre");
                $Nombre->value = $this->strXml->ReplaceEncodeUtf8($this->emisor->Nombre);
                $emisorElemnt->appendChild($Nombre);
            }
            // Agrega atributo de Regimen Fiscal
            $RegimenFiscal = $this->xmlRoot->createAttribute("RegimenFiscal");
            $RegimenFiscal->value = $this->strXml->ReplaceEncodeUtf8($this->emisor->RegimenFiscal);
            $emisorElemnt->appendChild($RegimenFiscal);

            return $emisorElemnt;
        } else {
            return null;
        }
    }
}
