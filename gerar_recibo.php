<?php
require 'conexao.php';
// require 'fpdf.php';
require('fpdf/fpdf.php');

$id = $_GET['id'] ?? 0;
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,"Recibo de Venda #$id",0,1);

$res = $conn->query("SELECT * FROM itens_venda WHERE venda_id = $id");
$total = 0;
while ($row = $res->fetch_assoc()) {
    $sub = $row['preco'] * $row['quantidade'];
    $total += $sub;
    $pdf->Cell(0,10,"{$row['produto']} - {$row['quantidade']} x R$ {$row['preco']} = R$ " . number_format($sub, 2, ',', '.'),0,1);
}
$pdf->Ln();
$pdf->Cell(0,10,"Total: R$ " . number_format($total, 2, ',', '.'),0,1);
$pdf->Output();
?>