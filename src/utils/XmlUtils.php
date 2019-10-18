<?php

namespace rdomenzain\cfdi\utils\utils;

use DOMDocument;
use Exception;
use rdomenzain\cfdi\utils\models\tfd\TimbreFiscalDigital;
use SimpleXMLElement;
use XSLTProcessor;

/**
 * Clase de utilerias de XML, generacion de la cadena original, sellado, etc...
 */
class XmlUtils
{

    public function __construct()
    { }

    /**
     * Genera la cadena original del XML
     *
     * @param string $xml XML en texto del CFDI
     * @return string Cadena orifinal del XML
     */
    public function GeneraCadenaOriginal($xml)
    {
        $xmlTmp = new DOMDocument("1.0", "UTF-8");
        $xmlTmp->loadXML($xml);

        $xslt = new DOMDocument();
        $xsltFile = realpath(dirname(__FILE__) . '/../../lib/xslt/cadenaoriginal_3_3.xslt');
        $xslt->load($xsltFile);

        $proc = new XSLTProcessor();
        $proc->importStyleSheet($xslt);
        $cadena_original = $proc->transformToXML($xmlTmp);
        return $cadena_original;
    }

    /**
     * Genera el Sello del XML a partir de la cadena original
     *
     * @param string $cadenaOriginal Cadena original del XML
     * @param string $fileContent Contenido del archivo PEM
     * @param string $claveKey Clave de firmado sel PEM
     * @return string Regresa la cadena original sellada
     */
    public function GeneralSelloCfdi33($cadenaOriginal, $fileContent, $claveKey)
    {
        $utlCert = new CertificadoUtils();
        $keyPem = $utlCert->ConvertKey2Pem($fileContent, $claveKey);
        $pkeyid = openssl_pkey_get_private($keyPem);
        $sig = null;
        openssl_sign($cadenaOriginal, $sig, $pkeyid, OPENSSL_ALGO_SHA256);
        return base64_encode($sig);
    }

    /**
     * Regresa los datos del timbre fiscal digital
     *
     * @param string $xmlString XML en texto
     * @return rdomenzain\cfdi\utils\models\tfd\TimbreFiscalDigital Objeto con valores del timbre
     */
    public function GetDatosCompTimbreFiscalSAT33($xmlString)
    {
        $tfd = new TimbreFiscalDigital();
        try {
            $xml = $this->GetXML2Object($xmlString);
            if (isset($xml)) {
                if (count($xml->xpath('//cfdi:Comprobante')) > 0) {
                    if (count($xml->xpath('//cfdi:Comprobante//cfdi:Complemento')) > 0) {
                        if (count($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital')) > 0) {
                            $tfdNode = $xml->xpath('//cfdi:Comprobante//cfdi:Complemento//tfd:TimbreFiscalDigital')[0];
                            $tfd->setVersion($this->xml_attribute($tfdNode, 'Version'));
                            $tfd->setUUID($this->xml_attribute($tfdNode, 'UUID'));
                            $tfd->setFechaTimbrado($this->xml_attribute($tfdNode, 'FechaTimbrado'));
                            $tfd->setSelloCFD($this->xml_attribute($tfdNode, 'SelloCFD'));
                            $tfd->setNoCertificadoSAT($this->xml_attribute($tfdNode, 'NoCertificadoSAT'));
                            $tfd->setSelloSAT($this->xml_attribute($tfdNode, 'SelloSAT'));
                        }
                    }
                }
                return $tfd;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            error_log('Error al obtener los datos del timbre fiscal digital:: ' . $ex->getMessage());
            return null;
        }
    }

    /**
     * Convierte el XML en objeto
     *
     * @param string $xmlString XMl CFDI 33 en texto
     * @return SimpleXMLElement
     */
    public function GetXML2Object($xmlString)
    {
        try {
            libxml_use_internal_errors(true);
            $xml = new SimpleXMLElement($xmlString, null, false);
            $xml->registerXPathNamespace('cfdi', 'http://www.sat.gob.mx/cfd/3');
            $xml->registerXPathNamespace('tfd', 'http://www.sat.gob.mx/TimbreFiscalDigital');
            return $xml;
        } catch (Exception $exc) {
            error_log("Error al cargar el XML::: " . $exc->getMessage());
            return null;
        }
    }

    /**
     * Obtiene atributos de un nodo
     *
     * @param SimpleXMLElement $object Nodo del XML
     * @param string $attribute Nombre del atributo
     * @return string
     */
    private function xml_attribute($object, $attribute)
    {
        if (isset($object[$attribute])) {
            return (string) $object[$attribute];
        }
    }
}
