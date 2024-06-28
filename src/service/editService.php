<?php
require 'src/database/db.php';

// Recupera todas as empresas
$companies = $mysqli->query("SELECT id_empresa, nome FROM tbl_empresa");

// Recupera informações da conta que será editada
if (isset($_GET['idBill'])) {
    $id_bill = $_GET['idBill'];
    $result = $mysqli->query("SELECT cp.id_conta_pagar, cp.valor, cp.data_pagar, cp.pago, e.nome, e.id_empresa 
        FROM tbl_conta_pagar cp 
        JOIN tbl_empresa e ON cp.id_empresa = e.id_empresa
        WHERE cp.id_conta_pagar = $id_bill");
    $bill = $result->fetch_assoc();

    if(!$bill){
        header("Location: index.php");
    }
}

// Atualiza a conta no banco
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $id_bill = $_GET['idBill'];
    $id_company = $_POST['id_empresa'];
    $date_pay = $_POST['data_pagar'];
    $value = $_POST['valor'];
    $paid = $_POST['pago'];

    $stmt = $mysqli->prepare("UPDATE tbl_conta_pagar SET valor = ?, data_pagar = ?, pago = ?, id_empresa = ? WHERE id_conta_pagar = ?");
    $stmt->bind_param("dsiii", $value, $date_pay, $paid, $id_company, $id_bill);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
