<?php
// ARQUIVO: gerar_boleto.php
session_start();
include("conexao.php");
require_once 'dompdf/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Segurança básica
if (!isset($_SESSION['id'])) { die("Acesso negado"); }

$pedido_id = isset($_GET['pedido']) ? intval($_GET['pedido']) : 0;
$id_usuario = $_SESSION['id'];

// 1. REFAZER A CONSULTA (Pois é um novo arquivo/requisição)
$sql_user_info = "SELECT u.nome, u.cpf, e.rua, e.cidade, e.estado, p.total 
                  FROM pedidos p 
                  JOIN usuarios u ON p.id_usuario = u.id_usuario 
                  JOIN enderecos e ON u.id_usuario = e.usuario_id 
                  WHERE p.id = $pedido_id AND p.id_usuario = $id_usuario";

$res_user = mysqli_query($conn, $sql_user_info);

if (!$res_user || mysqli_num_rows($res_user) == 0) {
    die("Pedido não encontrado ou acesso não autorizado.");
}

$dados = mysqli_fetch_assoc($res_user);

// Prepara variáveis
$nome_cliente = $dados['nome'];
$cpf_cliente  = $dados['cpf'];
$end_cliente  = $dados['rua'] . " - " . $dados['cidade'] . "/" . $dados['estado'];
$total        = $dados['total'];

// Dados do Boleto
$data_vencimento = date('d/m/Y', strtotime('+3 days'));
$data_documento  = date('d/m/Y');
$valor_boleto    = number_format($total, 2, ',', '.');
$nosso_numero    = str_pad($pedido_id, 10, "0", STR_PAD_LEFT);

// HTML (O mesmo que você já fez)
$html = "
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        td { border: 1px solid #000; padding: 2px; vertical-align: top; }
        .no-border { border: none; }
        .header-boleto td { border: none; border-bottom: 2px solid #000; padding-bottom: 5px; }
        .codigo-banco { font-size: 16px; font-weight: bold; border-left: 2px solid #000; border-right: 2px solid #000; padding: 0 10px; text-align: center; }
        .linha-digitavel { font-size: 14px; font-weight: bold; text-align: right; }
        .label { font-size: 7px; text-transform: uppercase; color: #333; margin-bottom: 2px; display: block; }
        .dado { font-size: 10px; font-weight: bold; min-height: 12px; display: block; }
        .direita { text-align: right; }
        .fundo-cinza { background-color: #f0f0f0; }
        .barcode { height: 50px; background: repeating-linear-gradient(90deg, #000 1px, #fff 2px, #000 4px); margin-top: 10px; }
        .instrucoes { font-size: 9px; padding: 5px; }
    </style>
</head>
<body>
    
    <div style='border-bottom: 1px dashed #000; margin-bottom: 15px; padding-bottom: 10px;'>
        <table class='no-border'>
            <tr>
                <td class='no-border' style='font-size: 12px;'><strong>RECIBO DO PAGADOR</strong></td>
                <td class='no-border direita'>Vencimento: <strong>$data_vencimento</strong></td>
            </tr>
        </table>
        <table>
            <tr>
                <td><span class='label'>Beneficiário</span><span class='dado'>Minha Loja Online LTDA</span></td>
                <td width='150'><span class='label'>Agência/Código</span><span class='dado'>1234 / 56789-0</span></td>
            </tr>
            <tr>
                <td><span class='label'>Pagador</span><span class='dado'>$nome_cliente</span></td>
                <td><span class='label'>Nosso Número</span><span class='dado'>$nosso_numero</span></td>
            </tr>
            <tr>
                <td><span class='label'>Demonstrativo</span><br>Pedido #$pedido_id</td>
                <td><span class='label'>Valor Documento</span><span class='dado direita'>R$ $valor_boleto</span></td>
            </tr>
        </table>
    </div>

    <table class='header-boleto'>
        <tr>
            <td width='40'>LOGO</td> 
            <td width='50' class='codigo-banco'>001-9</td>
            <td class='linha-digitavel'>00190.00009 01234.567890 00000.000000 1 00000000000000</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan='5'><span class='label'>Local de Pagamento</span><span class='dado'>PAGÁVEL EM QUALQUER BANCO</span></td>
            <td width='150' class='fundo-cinza'><span class='label'>Vencimento</span><span class='dado'>$data_vencimento</span></td>
        </tr>
        <tr>
            <td colspan='5'><span class='label'>Beneficiário</span><span class='dado'>Minha Loja Online LTDA</span></td>
            <td class='fundo-cinza'><span class='label'>Agência/Código</span><span class='dado'>1234 / 56789-0</span></td>
        </tr>
        <tr>
            <td><span class='label'>Data Doc</span><span class='dado'>$data_documento</span></td>
            <td><span class='label'>Nº Doc</span><span class='dado'>$pedido_id</span></td>
            <td><span class='label'>Espécie</span><span class='dado'>DM</span></td>
            <td><span class='label'>Aceite</span><span class='dado'>N</span></td>
            <td><span class='label'>Proc</span><span class='dado'>$data_documento</span></td>
            <td class='fundo-cinza'><span class='label'>Nosso Número</span><span class='dado'>$nosso_numero</span></td>
        </tr>
        <tr>
            <td colspan='5' rowspan='5'>
                <span class='label'>Instruções</span>
                <div class='instrucoes'><br>PEDIDO #$pedido_id NA LOJA VIRTUAL.</div>
            </td>
            <td class='fundo-cinza'><span class='label'>(=) Valor Documento</span><span class='dado direita'>R$ $valor_boleto</span></td>
        </tr>
        <tr><td class='fundo-cinza'>&nbsp;</td></tr>
        <tr><td class='fundo-cinza'>&nbsp;</td></tr>
        <tr><td class='fundo-cinza'>&nbsp;</td></tr>
        <tr><td class='fundo-cinza'>&nbsp;</td></tr>
        <tr>
            <td colspan='6'>
                <span class='label'>Pagador</span>
                <span class='dado'>$nome_cliente - CPF: $cpf_cliente</span>
                <span class='dado'>$end_cliente</span>
            </td>
        </tr>
    </table>
    <div class='barcode'></div>
</body>
</html>
";

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('chroot', realpath(''));
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Envia o arquivo
$dompdf->stream("boleto-pedido-$pedido_id.pdf", ["Attachment" => true]);
?>