<?php

namespace rdomenzain\cfdi\utils\models;

class Comprobante
{

    public $Version;
    public $Serie;
    public $Folio;
    public $Fecha;
    public $Sello;
    public $FormaPago;
    public $NoCertificado;
    public $Certificado;
    public $CondicionesDePago;
    public $SubTotal;
    public $Descuento;
    public $Moneda;
    public $TipoCambio;
    public $Total;
    public $TipoDeComprobante;
    public $MetodoPago;
    public $LugarExpedicion;
    public $Confirmacion;
    /* @var $CfdiRelacionados CfdiRelacionados */
    public $CfdiRelacionados;
    /* @var $Emisor Emisor */
    public $Emisor;
    /* @var $Receptor Receptor */
    public $Receptor;
    /* @var $Conceptos Conceptos */
    public $Conceptos;
    /* @var $Impuestos Impuestos */
    public $Impuestos;
    /* @var $Complemento Complemento */
    public $Complemento;
    /* @var $Addenda Addenda */
    public $Addenda;
}
