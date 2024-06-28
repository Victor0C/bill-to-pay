<?php
$host = '';
$db = '';
$user = '';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

date_default_timezone_set('America/Bahia');
?>
