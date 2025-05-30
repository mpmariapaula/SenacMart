<?php
include 'conexao.php';
$res = $conn->query("SELECT * FROM vendas ORDER BY data DESC");
echo "<h2>Histórico de Vendas</h2><table border=1><tr><th>ID</th><th>Operador</th><th>Data</th></tr>";
while ($v = $res->fetch_assoc()) {
    echo "<tr><td>{$v['id']}</td><td>{$v['operador']}</td><td>{$v['data']}</td></tr>";
}
echo "</table>";
?>