<?php
require 'src/database/db.php';

// Cadastra conta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $id_company = $_POST['id_empresa'];
    $date_pay = $_POST['data_pagar'];
    $value = $_POST['valor'];

    $stmt = $mysqli->prepare("INSERT INTO tbl_conta_pagar (valor, data_pagar, id_empresa) VALUES (?, ?, ?)");
    $stmt->bind_param("dsi", $value, $date_pay, $id_company);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}

// Excluir conta a pagar
if (isset($_GET['delete'])) {
    $id_bill_pay = $_GET['delete'];
    $mysqli->query("DELETE FROM tbl_conta_pagar WHERE id_conta_pagar = $id_bill_pay");
    header("Location: index.php");
    exit();
}

// Marcar conta como paga
if (isset($_GET['paid'])) {
    $id_bill_pay = $_GET['paid'];
    $result = $mysqli->query("SELECT valor, data_pagar, pago FROM tbl_conta_pagar WHERE id_conta_pagar = $id_bill_pay");
    $bill = $result->fetch_assoc();    

    if ($bill['pago'] == 1) {
        header("Location: index.php");
        exit();
    }

    $date_pay = new DateTime($bill['data_pagar'],);
    $date_pay = $date_pay->format('d-m-Y');
    
    $today = new DateTime();
    $today = $today->format('d-m-Y');

    $value = $bill['valor'];

    //Aqui aplico o desconto
    if ($today < $date_pay) {
        $value -= $value * 0.05;
    }
    if ($today > $date_pay) {
        $value += $value * 0.10; 
    }

    $stmt = $mysqli->prepare("UPDATE tbl_conta_pagar SET valor = ?, pago = 1 WHERE id_conta_pagar = ?");
    $stmt->bind_param("di", $value, $id_bill_pay);
    $stmt->execute();
    $stmt->close();

   header("Location: index.php");
    exit();
}

// Recupera todas as empresas
$companies = $mysqli->query("SELECT id_empresa, nome FROM tbl_empresa");

// Recupera todas as contas a pagar
$filter_companies = $_GET['empresa'] ?? '';
$filter_value = $_GET['valor'] ?? '';
$filter_operator = $_GET['valor_operador'] ?? '';
$filtro_date = $_GET['data'] ?? '';

$query = "SELECT cp.id_conta_pagar, cp.valor, cp.data_pagar, cp.pago, e.nome 
          FROM tbl_conta_pagar cp 
          JOIN tbl_empresa e ON cp.id_empresa = e.id_empresa 
          WHERE e.nome LIKE '%$filter_companies%'";

if ($filter_operator && $filter_value) {
    $valid_operators = ['>', '<', '='];
    if (in_array($filter_operator, $valid_operators)) {
        $query .= " AND cp.valor $filter_operator $filter_value";
    }
}

if ($filtro_date) {
    $query .= " AND cp.data_pagar = '$filtro_date'";
}

$bills = $mysqli->query($query);

function format_value($value) {
    return 'R$ ' . number_format($value, 2, ',', '.');
}
