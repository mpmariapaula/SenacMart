<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SenacMart — Histórico de Vendas</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'conexao.php';

$res   = $conn->query("SELECT * FROM vendas ORDER BY data DESC");
$total = $conn->query("SELECT COUNT(*) AS qtd, SUM(total) AS soma FROM vendas")->fetch_assoc();
?>

  <!-- CABEÇALHO -->
  <header class="cabecalho">
    <div class="cabecalho-esq">
      <span class="logo-texto">SenacMart</span>
      <span class="cabecalho-titulo">Histórico de vendas</span>
    </div>
    <div class="cabecalho-dir">
      <a href="index.html"><button class="btn-sair">&#8592; Voltar ao caixa</button></a>
    </div>
  </header>

  <!-- CONTEÚDO -->
  <main class="dashboard-wrapper">

    <!-- CARDS DE RESUMO -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:24px">
      <div class="card" style="padding:18px 22px">
        <div style="font-size:13px;color:var(--cinza-texto);margin-bottom:6px">Total de vendas</div>
        <div style="font-size:28px;font-weight:bold;color:var(--azul)"><?php echo intval($total['qtd']); ?></div>
      </div>
      <div class="card" style="padding:18px 22px">
        <div style="font-size:13px;color:var(--cinza-texto);margin-bottom:6px">Valor total registrado</div>
        <div style="font-size:28px;font-weight:bold;color:var(--verde)">
          R$ <?php echo number_format(floatval($total['soma']), 2, ',', '.'); ?>
        </div>
      </div>
    </div>

    <!-- TABELA -->
    <div class="card" style="padding:0;overflow:hidden">
      <div style="padding:18px 22px;border-bottom:1px solid var(--cinza-borda)">
        <span style="font-size:16px;font-weight:600">Vendas registradas</span>
      </div>
      <div style="overflow-x:auto">
        <table class="tabela-base dashboard-wrapper">
          <thead>
            <tr>
              <th>#</th>
              <th>Operador</th>
              <th>Data e hora</th>
              <th>Total</th>
              <th>Recibo</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($v = $res->fetch_assoc()): ?>
            <tr>
              <td style="color:var(--cinza-texto)"><?php echo $v['id']; ?></td>
              <td><?php echo htmlspecialchars($v['operador']); ?></td>
              <td><?php echo date('d/m/Y H:i', strtotime($v['data'])); ?></td>
              <td style="font-weight:600;color:var(--azul)">
                R$ <?php echo number_format(floatval($v['total']), 2, ',', '.'); ?>
              </td>
              <td>
                <a href="gerar_recibo.php?id=<?php echo $v['id']; ?>" target="_blank">
                  <button class="btn btn-secundario btn-sm">Ver recibo</button>
                </a>
              </td>
            </tr>
            <?php endwhile; ?>

            <?php if ($total['qtd'] == 0): ?>
            <tr>
              <td colspan="5" style="text-align:center;color:var(--cinza-texto);padding:32px">
                Nenhuma venda registrada ainda.
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>
</body>
</html>
