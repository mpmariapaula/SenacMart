<?php
include 'conexao.php';

$busca = $_GET['busca'] ?? '';
$sql = "SELECT * FROM produtos WHERE codigo = ? OR nome LIKE ?";
$stmt = $conn->prepare($sql);
$like = "%$busca%";
$stmt->bind_param("ss", $busca, $like);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["erro" => "Produto não encontrado."]);
}
?>