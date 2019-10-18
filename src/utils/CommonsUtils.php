<?php

namespace rdomenzain\cfdi\utils\utils;

use DateTime;
use DateTimeZone;

class CommonsUtils
{

    public function __construct()
    { }

    /**
     * Remplaza caracteres especiales
     *
     * @param string $textOrigin
     * @return string
     */
    public function ReplaceEncodeUtf8($textOrigin)
    {
        $textEncoded = $textOrigin;
        $textEncoded = str_replace("&", '&amp;', $textEncoded);
        $textEncoded = str_replace('"', '&quot;', $textEncoded);
        $textEncoded = str_replace('<', '&lt;', $textEncoded);
        $textEncoded = str_replace('>', '&gt;', $textEncoded);
        $textEncoded = str_replace('‘', '&apos;', $textEncoded);
        return $textEncoded;
    }

    /**
     * Fecha ISO8601 actual del sistema
     *
     * @return string
     */
    public function GetFechaActualCFDI()
    {
        $dt = new DateTime();
        $dt->setTimeZone(new DateTimeZone('America/Mexico_City'));
        return $dt->format('Y-m-d\TH:i:s');
    }

    /**
     * Converte una fecha en formato ISO8601
     *
     * @param string $fecha
     * @return string
     */
    public function GetFechaISO8601($fecha)
    {
        $time = date_create_from_format('j/m/Y H:i:s', $fecha);
        return $time->format('Y-m-d\TH:i:s');
    }

    /**
     * Da formato a un numero
     *
     * @param float $n
     * @param int $numDecimales
     * @return string
     */
    public function FormatNumber($numero, $numDecimales)
    {
        return number_format($numero, $numDecimales, '.', '');
    }
}
