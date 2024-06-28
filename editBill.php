<?php
    require 'src/service/editService.php'
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Controle Financeiro - Contas a Pagar</title>
        <link rel="shortcut icon" type="imagex/png" href="src/assets/logo.png">
        <link rel="stylesheet" href="src/styles/editBill.css">
    </head>
    <body>
        <div class="containerEdit">
            <div class="editBill" >
                <h1>Editar Conta</h1>
                <form method="post">
                    <div class="formsIpunt">
                        <label for="id_empresa">Empresa:</label>
                        <select name="id_empresa" id="id_empresa">
                            <option value="<?= $bill['id_empresa'] ?>"><?= $bill['nome'] ?></option>

                            <?php while ($row = $companies->fetch_assoc()): ?>
                                <?php if ($row['id_empresa'] != $bill['id_empresa']): ?>
                                    <option value="<?= $row['id_empresa'] ?>"><?= $row['nome'] ?></option>
                                <?php endif; ?>
                            <?php endwhile; ?>
                            
                        </select>
                    </div>

                    <div class="formsIpunt">
                        <label for="data_pagar">Data a ser Pago:</label>
                        <input type="date" name="data_pagar" id="data_pagar" value="<?= $bill['data_pagar'] ?>">
                    </div>
    
                    <div class="formsIpunt">
                        <label for="valor">Valor:</label>
                        <input type="number" step="0.01" name="valor" id="valor" value="<?= $bill['valor'] ?>">
                    </div>

                    <div class="formsIpunt">
                        <label for="pago">Pago:</label>
                        <select name="pago" id="pago">
                            <option value=1>Sim</option>
                            <option value=0>Não</option>
                        </select>
                    </div>
    
                    <button type="submit" name="add">Salvar</button>
                </form>
            </div>
        </div>
    </body>
</html>