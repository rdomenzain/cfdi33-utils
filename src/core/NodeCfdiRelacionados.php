<?php

namespace rdomenzain\cfdi\utils\core;

class NodeCfdiRelacionados
{
    /* @var $CfdiRelacionados CfdiRelacionados */
    private $CfdiRelacionados;
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;

    function __construct($CfdiRelacionados, $xmlRoot)
    {
        $this->CfdiRelacionados = $CfdiRelacionados;
        $this->xmlRoot = $xmlRoot;
    }

    public function GeneraNodo()
    {
        if ($this->CfdiRelacionados != null && $this->CfdiRelacionados->CfdiRelacionado != null) {
            // Crea elemento CfdiRelacionados
            $elememtCfdiRelacionados = $this->xmlRoot->createElement("cfdi:CfdiRelacionados");
            // Agrega Tipo de relacion
            $TipoRelacion = $this->xmlRoot->createAttribute("TipoRelacion");
            $TipoRelacion->value = $this->CfdiRelacionados->TipoRelacion;
            $elememtCfdiRelacionados->appendChild($TipoRelacion);

            // Agrega elemento CfdiRelacionado
            foreach ($this->CfdiRelacionados->CfdiRelacionado as $one) {
                $elememtCfdiRelacionado = $this->xmlRoot->createElement("cfdi:CfdiRelacionado");
                $UUID = $this->xmlRoot->createAttribute("UUID");
                $UUID->value = $one->UUID;
                $elememtCfdiRelacionado->appendChild($UUID);
                $elememtCfdiRelacionados->appendChild($elememtCfdiRelacionado);
            }

            return $elememtCfdiRelacionados;
        } else {
            return null;
        }
    }
}
