<?php
date_default_timezone_set("America/Santiago");
$fechaYHora = date("Y-m-d H:i:s");
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
$ip = $ip ?: "Desconocida";
$mensaje = sprintf("La IP %s accedió en %s%s", $ip, $fechaYHora, PHP_EOL);
file_put_contents("ip.txt", $mensaje, FILE_APPEND);
?>