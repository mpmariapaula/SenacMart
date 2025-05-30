<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];

    // Verificar se já existe produto com mesmo código
    $check = $conn->prepare("SELECT * FROM produtos WHERE codigo = ?");
    $check->bind_param("s", $codigo);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        echo "⚠️ Produto com esse código de barras já existe.";
        echo '<br><a href="cadastrar_produtos.html">Voltar</a>';
    } else {
        $stmt = $conn->prepare("INSERT INTO produtos (codigo, nome, preco) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $codigo, $nome, $preco);
        if ($stmt->execute()) {
            echo "✅ Produto cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }
        echo '<br><a href="cadastrar_produtos.html">Cadastrar outro</a>';
        echo '<br><a href="index.html">Ir para Vendas</a>';
    }
}
?>
