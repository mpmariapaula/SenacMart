<?php
session_start();
include 'conexao.php';

$data = json_decode(file_get_contents("php://input"), true);
$operador = $_SESSION['operador'] ?? 'Desconhecido';
$conn->query("INSERT INTO vendas (operador) VALUES ('$operador')");
$id_venda = $conn->insert_id;

foreach ($data as $item) {
    $sql = "INSERT INTO itens_venda (venda_id, produto, preco, quantidade)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdi", $id_venda, $item['nome'], $item['preco'], $item['qtd']);
    $stmt->execute();
}

echo $id_venda;
?>