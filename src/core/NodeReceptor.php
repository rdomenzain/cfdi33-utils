<?php

namespace rdomenzain\cfdi\utils\core;

use rdomenzain\cfdi\utils\utils\CommonsUtils;

class NodeReceptor
{
    /* @var $receptor Receptor */
    private $receptor;
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($receptor, $xmlRoot)
    {
        $this->receptor = $receptor;
        $this->xmlRoot = $xmlRoot;
        $this->strXml = new CommonsUtils();
    }

    public function GeneraNodo()
    {
        if ($this->receptor != null) {
            // Crea elemento del emisor
            $receptorElemnt = $this->xmlRoot->createElement("cfdi:Receptor");
            // Agrega atributo de RFC
            $Rfc = $this->xmlRoot->createAttribute("Rfc");
            $Rfc->value = $this->strXml->ReplaceEncodeUtf8($this->receptor->Rfc);
            $receptorElemnt->appendChild($Rfc);
            //Agrega atributo de nombre
            if ($this->receptor->Nombre != null && !empty($this->receptor->Nombre)) {
                $Nombre = $this->xmlRoot->createAttribute("Nombre");
                $Nombre->value = $this->strXml->ReplaceEncodeUtf8($this->receptor->Nombre);
                $receptorElemnt->appendChild($Nombre);
            }
            //Agrega atributo Residencia fiscal
            if ($this->receptor->ResidenciaFiscal != null && !empty($this->receptor->ResidenciaFiscal)) {
                $ResidenciaFiscal = $this->xmlRoot->createAttribute("ResidenciaFiscal");
                $ResidenciaFiscal->value = $this->receptor->ResidenciaFiscal;
                $receptorElemnt->appendChild($ResidenciaFiscal);
            }
            //Agrega atributo Num Reg tributario
            if ($this->receptor->NumRegIdTrib != null && !empty($this->receptor->NumRegIdTrib)) {
                $NumRegIdTrib = $this->xmlRoot->createAttribute("NumRegIdTrib");
                $NumRegIdTrib->value = $this->receptor->NumRegIdTrib;
                $receptorElemnt->appendChild($NumRegIdTrib);
            }
            // Agrega atributo de Uso CFDI
            $UsoCFDI = $this->xmlRoot->createAttribute("UsoCFDI");
            $UsoCFDI->value = $this->receptor->UsoCFDI;
            $receptorElemnt->appendChild($UsoCFDI);

            return $receptorElemnt;
        } else {
            return null;
        }
    }
}
