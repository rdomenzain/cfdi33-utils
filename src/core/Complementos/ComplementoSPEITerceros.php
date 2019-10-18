<?php

namespace rdomenzain\cfdi\utils\core\Complementos;

class ComplementoSPEITerceros
{
    /* @var $xmlRoot DOMDocument */
    private $xmlRoot;
    /* @var $tpe Complemento_SPEI */
    private $spei;
    /* @var $complemento DOMElement */
    private $complemento;
    /* @var $strXml StringUtils */
    private $strXml;

    function __construct($spei, $xmlRoot)
    {
        $this->xmlRoot = $xmlRoot;
        $this->spei = $spei;
        $this->strXml = new StringUtils();
    }

    public function GeneraComplemento()
    {
        // Crea el complemento
        $this->complemento = $this->xmlRoot->createElement("spei:Complemento_SPEI");
        // Genera Nodo de Datos de Spei a Terceros
        $this->GeneraNodoSpeiTerceros();
        return $this->complemento;
    }

    private function GeneraNodoSpeiTerceros()
    {
        if ($this->spei->SPEI_Tercero != null && count($this->spei->SPEI_Tercero) > 0) {
            foreach ($this->spei->SPEI_Tercero as $terceros) {
                // Agrega nodo de spei a tercero
                $elementSpeiTercero = $this->xmlRoot->createElement("spei:SPEI_Tercero");
                // Agrega atributo FechaOperacion
                $FechaOperacion = $this->xmlRoot->createAttribute("FechaOperacion");
                $FechaOperacion->value = $terceros->FechaOperacion;
                $elementSpeiTercero->appendChild($FechaOperacion);
                // Agrega atributo Hora
                $Hora = $this->xmlRoot->createAttribute("Hora");
                $Hora->value = $terceros->Hora;
                $elementSpeiTercero->appendChild($Hora);
                // Agrega atributo ClaveSPEI
                $ClaveSPEI = $this->xmlRoot->createAttribute("ClaveSPEI");
                $ClaveSPEI->value = $terceros->ClaveSPEI;
                $elementSpeiTercero->appendChild($ClaveSPEI);
                // Agrega atributo sello
                $sello = $this->xmlRoot->createAttribute("sello");
                $sello->value = $terceros->sello;
                $elementSpeiTercero->appendChild($sello);
                // Agrega atributo numeroCertificado
                $numeroCertificado = $this->xmlRoot->createAttribute("numeroCertificado");
                $numeroCertificado->value = $this->strXml->replaceEcodeUt8($terceros->numeroCertificado);
                $elementSpeiTercero->appendChild($numeroCertificado);
                // Agrega atributo cadenaCDA
                $cadenaCDA = $this->xmlRoot->createAttribute("cadenaCDA");
                $cadenaCDA->value = $this->strXml->replaceEcodeUt8($terceros->cadenaCDA);
                $elementSpeiTercero->appendChild($cadenaCDA);
                // Genera nodo del Ordenante
                $elementOrdenante = $this->GeneraNodoOrdenante($terceros->Ordenante);
                if ($elementOrdenante != null) {
                    $elementSpeiTercero->appendChild($elementOrdenante);
                }
                // Genera nodo del Beneficiario
                $elementBeneficiario = $this->GeneraNodoBeneficiario($terceros->Beneficiario);
                if ($elementBeneficiario != null) {
                    $elementSpeiTercero->appendChild($elementBeneficiario);
                }
                // Agrega a nodo principal
                $this->complemento->appendChild($elementSpeiTercero);
            }
        }
    }

    private function GeneraNodoOrdenante($Ordenante)
    {
        if ($Ordenante != null && !empty($Ordenante)) {
            // Crea nodo de ordenante
            $elementOrdenante = $this->xmlRoot->createElement("spei:Ordenante");
            // Agrega atributo BancoEmisor
            $BancoEmisor = $this->xmlRoot->createAttribute("BancoEmisor");
            $BancoEmisor->value = $this->strXml->replaceEcodeUt8($Ordenante->BancoEmisor);
            $elementOrdenante->appendChild($BancoEmisor);
            // Agrega atributo Nombre
            $Nombre = $this->xmlRoot->createAttribute("Nombre");
            $Nombre->value = $this->strXml->replaceEcodeUt8($Ordenante->Nombre);
            $elementOrdenante->appendChild($Nombre);
            // Agrega atributo TipoCuenta
            $TipoCuenta = $this->xmlRoot->createAttribute("TipoCuenta");
            $TipoCuenta->value = $Ordenante->TipoCuenta;
            $elementOrdenante->appendChild($TipoCuenta);
            // Agrega atributo Cuenta
            $Cuenta = $this->xmlRoot->createAttribute("Cuenta");
            $Cuenta->value = $Ordenante->Cuenta;
            $elementOrdenante->appendChild($Cuenta);
            // Agrega atributo RFC
            $RFC = $this->xmlRoot->createAttribute("RFC");
            $RFC->value = $this->strXml->replaceEcodeUt8($Ordenante->RFC);
            $elementOrdenante->appendChild($RFC);
            // Retorna elemento
            return $elementOrdenante;
        } else {
            return null;
        }
    }

    private function GeneraNodoBeneficiario($Beneficiario)
    {
        if ($Beneficiario != null && !empty($Beneficiario)) {
            // Crea nodo de ordenante
            $elementBeneficiario = $this->xmlRoot->createElement("spei:Beneficiario");
            // Agrega atributo BancoReceptor
            $BancoReceptor = $this->xmlRoot->createAttribute("BancoReceptor");
            $BancoReceptor->value = $this->strXml->replaceEcodeUt8($Beneficiario->BancoReceptor);
            $elementBeneficiario->appendChild($BancoReceptor);
            // Agrega atributo Nombre
            $Nombre = $this->xmlRoot->createAttribute("Nombre");
            $Nombre->value = $this->strXml->replaceEcodeUt8($Beneficiario->Nombre);
            $elementBeneficiario->appendChild($Nombre);
            // Agrega atributo TipoCuenta
            $TipoCuenta = $this->xmlRoot->createAttribute("TipoCuenta");
            $TipoCuenta->value = $Beneficiario->TipoCuenta;
            $elementBeneficiario->appendChild($TipoCuenta);
            // Agrega atributo Cuenta
            $Cuenta = $this->xmlRoot->createAttribute("Cuenta");
            $Cuenta->value = $Beneficiario->Cuenta;
            $elementBeneficiario->appendChild($Cuenta);
            // Agrega atributo RFC
            $RFC = $this->xmlRoot->createAttribute("RFC");
            $RFC->value = $this->strXml->replaceEcodeUt8($Beneficiario->RFC);
            $elementBeneficiario->appendChild($RFC);
            // Agrega atributo Concepto
            $Concepto = $this->xmlRoot->createAttribute("Concepto");
            $Concepto->value = $this->strXml->replaceEcodeUt8($Beneficiario->Concepto);
            $elementBeneficiario->appendChild($Concepto);
            // Agrega atributo IVA
            if ($Beneficiario->IVA != null && !empty($Beneficiario->IVA)) {
                $IVA = $this->xmlRoot->createAttribute("IVA");
                $IVA->value = $Beneficiario->IVA;
                $elementBeneficiario->appendChild($IVA);
            }
            // Agrega atributo MontoPago
            $MontoPago = $this->xmlRoot->createAttribute("MontoPago");
            $MontoPago->value = $Beneficiario->MontoPago;
            $elementBeneficiario->appendChild($MontoPago);
            // Retorna elemento
            return $elementBeneficiario;
        } else {
            return null;
        }
    }
}
