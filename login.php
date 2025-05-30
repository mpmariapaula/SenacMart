<?php
session_start();
include 'conexao.php';

$nome = $_POST['nome'] ?? '';

$sql = "SELECT * FROM operadores WHERE nome = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['operador'] = $nome;
    header("Location: index.html");
} else {
    echo "Operador não encontrado.";
}
?>