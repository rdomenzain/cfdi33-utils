<?php

namespace rdomenzain\cfdi\utils\core\Complementos;

class ComplementoLeyendasFiscales
{
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $leyendasFisc LeyendasFiscales */
    private $leyendasFisc;
    /* @var $complemento DOMElement */
    private $complemento;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($leyendasFisc, $xmlRoot)
    {
        $this->xmlRoot = $xmlRoot;
        $this->leyendasFisc = $leyendasFisc;
        $this->strXml = new StringUtils();
    }

    public function GeneraComplemento()
    {
        // Crea el complemento
        $this->complemento = $this->xmlRoot->createElement("leyendasFisc:LeyendasFiscales");
        // Agrega atributo version
        $version = $this->xmlRoot->createAttribute("version");
        $version->value = "1.0";
        $this->complemento->appendChild($version);
        // Genera los nodos de Leyenda
        $this->GeneraLeyenda();
        // Regresa el complemento
        return $this->complemento;
    }

    private function GeneraLeyenda()
    {
        // Genera el nodo de Leyenda
        if ($this->leyendasFisc->Leyenda != null && count($this->leyendasFisc->Leyenda) > 0) {
            foreach ($this->leyendasFisc->Leyenda as $ley) {
                // Agrega nodo de Retenciones locales
                $elementLey = $this->xmlRoot->createElement("leyendasFisc:Leyenda");
                // Agrega atributo ImpLocRetenido
                if ($ley->disposicionFiscal != null && !empty($ley->disposicionFiscal)) {
                    $disposicionFiscal = $this->xmlRoot->createAttribute("disposicionFiscal");
                    $disposicionFiscal->value = $this->strXml->replaceEcodeUt8($ley->disposicionFiscal);
                    $elementLey->appendChild($disposicionFiscal);
                }
                // Agrega atributo ImpLocRetenido
                if ($ley->norma != null && !empty($ley->norma)) {
                    $norma = $this->xmlRoot->createAttribute("norma");
                    $norma->value = $this->strXml->replaceEcodeUt8($ley->norma);
                    $elementLey->appendChild($norma);
                }
                // Agrega atributo ImpLocRetenido
                $textoLeyenda = $this->xmlRoot->createAttribute("textoLeyenda");
                $textoLeyenda->value = $this->strXml->replaceEcodeUt8($ley->textoLeyenda);
                $elementLey->appendChild($textoLeyenda);
                // Lo agrega al nodo principal
                $this->complemento->appendChild($elementLey);
            }
        }
    }
}
