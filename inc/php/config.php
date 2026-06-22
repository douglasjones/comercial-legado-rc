<?php
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
date_default_timezone_set('America/Sao_Paulo');

// cookies de sessão mais seguros para produção
$cookieSecure = getenv('SESSION_COOKIE_SECURE') === '1';
$cookieSameSite = getenv('SESSION_COOKIE_SAMESITE') ? getenv('SESSION_COOKIE_SAMESITE') : 'Lax';
if (PHP_VERSION_ID >= 70300) {
    session_set_cookie_params(array(
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $cookieSecure,
        'httponly' => true,
        'samesite' => $cookieSameSite
    ));
}
session_start();

//Seta os parametros globais de timeout
ini_set('session.gc_maxlifetime', 2400); // 40 minutos
ini_set('session.cookie_lifetime', 2400);

//Define o cabecalho
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
// ini_set('default_charset','ISO-8859-1'); Padro do desenvolvimento são arquivos UTF-8

?>
