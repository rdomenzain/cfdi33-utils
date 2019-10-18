<?php

namespace rdomenzain\cfdi\utils\utils;

/**
 * Utilerias para el procesamiento del certificado y llave primaria
 */
class CertificadoUtils
{

    public function __construct()
    { }

    /**
     * General un PEM del certificado
     */
    public function GeneraCertificado2Pem($fileCertContent)
    {
        $certificado = str_replace(array('\n', '\r'), '', base64_encode($fileCertContent));
        return $certificado;
    }

    public function GetNumCertificado($fileCertContent)
    {
        $datos = $this->convertCertToPem($fileCertContent);
        $data = openssl_x509_parse($datos, true);
        return $this->ConvertNoSerie($data['serialNumber']);
    }

    public function GetInfoCertificado($fileCertContent)
    {
        $datos = $this->convertCertToPem($fileCertContent);
        $data = openssl_x509_parse($datos, true);
        $valores = array(
            "razon" => $data['subject']['CN'],
            "rfc" => $data['subject']['x500UniqueIdentifier'],
            "ValidoDesde" => date('Y-m-d H:i:s', $data['validFrom_time_t']),
            "validoHasta" => date('Y-m-d H:i:s', $data['validTo_time_t'])
        );

        return $valores;
    }

    /**
     * Convierte un llave primaria .key a un archivo PEM, requerido para facturar
     * sellar, etc...
     * @param string $fileContent Contenido del archivo key
     * @param string $key Llave de firmado
     * @return string Retorna el contenido del PEM
     */
    public function ConvertKey2Pem($fileContent, $key)
    {
        $fileKey = tmpfile();
        $fileKeyPath = stream_get_meta_data($fileKey)['uri'];
        file_put_contents($fileKeyPath, $fileContent);

        $fileKeyPem = tmpfile();
        $fileKeyPemPath = stream_get_meta_data($fileKeyPem)['uri'];

        $cmdKey = 'openssl pkcs8 -inform DER -in ' . $fileKeyPath . ' -passin pass:' . $key . ' -out ' . $fileKeyPemPath;
        exec($cmdKey);

        return file_get_contents($fileKeyPemPath);
    }

    public function ValidatePrivateKey($fileKeyContent)
    {
        $pubkeyid = $this->convertCertToPem($fileKeyContent);
        $ok = openssl_x509_checkpurpose($pubkeyid, X509_PURPOSE_ANY);
        if ($ok) {
            echo "Certificado emitido por el SAT<br>";
        } else {
            echo "Certificado apocrifo, No es del SAT<br>";
        }
    }

    public function ValidateCertificado($fileCertContent)
    {
        $cert = $this->convertCertToPem($fileCertContent);
        $ok = openssl_get_publickey(openssl_x509_read($cert));
        if ($ok) {
            echo "Certificado emitido por el SAT.<br>";
        } else {
            echo "Certificado interno Incorrecto.<br>";
        }
    }

    private function ConvertNoSerie($dec)
    {
        $hex = $this->bcdechex($dec);
        $ser = "";
        for ($i = 1; $i < strlen($hex); $i = $i + 2) {
            $ser .= substr($hex, $i, 1);
        }
        return $ser;
    }

    private function bcdechex($dec)
    {
        $last = bcmod($dec, 16);
        $remain = bcdiv(bcsub($dec, $last), 16);
        if ($remain == 0) {
            return dechex($last);
        } else {
            return $this->bcdechex($remain) . dechex($last);
        }
    }

    private function convertCertToPem($file)
    {
        return '-----BEGIN CERTIFICATE-----' . PHP_EOL
            . chunk_split(base64_encode($file), 64, PHP_EOL)
            . '-----END CERTIFICATE-----' . PHP_EOL;
    }

}
