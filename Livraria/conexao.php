<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "biblioteca1";

$conn = new mysqli($servidor, $usuario, $senha, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}