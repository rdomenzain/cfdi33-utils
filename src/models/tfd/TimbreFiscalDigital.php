<?php

namespace rdomenzain\cfdi\utils\models\tfd;

class TimbreFiscalDigital
{

    private $Version;
    private $UUID;
    private $FechaTimbrado;
    private $SelloCFD;
    private $NoCertificadoSAT;
    private $SelloSAT;

    public function __construct()
    { }

    public function setVersion($Version)
    {
        $this->Version = $Version;
    }

    public function getVersion()
    {
        return $this->Version;
    }

    public function setUUID($UUID)
    {
        $this->UUID = $UUID;
    }

    public function getUUID()
    {
        return $this->UUID;
    }

    public function setFechaTimbrado($FechaTimbrado)
    {
        $this->FechaTimbrado = $FechaTimbrado;
    }

    public function getFechaTimbrado()
    {
        return $this->FechaTimbrado;
    }

    public function setSelloCFD($SelloCFD)
    {
        $this->SelloCFD = $SelloCFD;
    }

    public function getSelloCFD()
    {
        return $this->SelloCFD;
    }

    public function setNoCertificadoSAT($NoCertificadoSAT)
    {
        $this->NoCertificadoSAT = $NoCertificadoSAT;
    }

    public function getNoCertificadoSAT()
    {
        return $this->NoCertificadoSAT;
    }

    public function setSelloSAT($SelloSAT)
    {
        $this->SelloSAT = $SelloSAT;
    }

    public function getSelloSAT()
    {
        return $this->SelloSAT;
    }
}
