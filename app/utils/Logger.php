<?php

require_once(__DIR__ . '/../../config/Config.php');

class Logger{
    private const LOG_FILE = __DIR__ .'/../../logs/log.txt';

    public static function escribirLogs($mensaje) {
        $fecha = date('Y-m-d H:i:s');
        $mensaje = "[$fecha] $mensaje" . PHP_EOL;
        file_put_contents(self::LOG_FILE, $mensaje, FILE_APPEND);
    }

}

?>