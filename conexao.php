<?php
$host = "localhost";
$user = "root";
$senha = "";
$banco = "supermercado";

$conn = new mysqli($host, $user, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>