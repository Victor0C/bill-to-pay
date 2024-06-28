<?php 
    require 'src/service/mainService.php'
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Bill to Pay</title>
        <link rel="shortcut icon" type="imagex/png" href="src/assets/logo.png">
        <link rel="stylesheet" href="src/styles/main.css">
    </head>
    <body>
        <div class="container">
            <div class="top">
                <div class="addBill">
                    <h1>Adicionar conta a pagar</h1>
                    <form method="post">
                        <div class="formsIpunt">
                            <label for="id_empresa">Empresa:</label>
                            <select name="id_empresa" id="id_empresa">
                                <?php while ($row = $companies->fetch_assoc()):?>
                                    <option value="<?= $row['id_empresa'] ?>"><?= $row['nome'] ?></option>
                                <?php endwhile;?>
                            </select>
                        </div>
            
                        <div class="formsIpunt">
                            <label for="data_pagar">Data a ser Pago:</label>
                            <input type="date" name="data_pagar" id="data_pagar" required>
                        </div>
            
                        <div class="formsIpunt">
                            <label for="valor">Valor:</label>
                            <input type="number" step="0.01" name="valor" id="valor" required>
                        </div>
            
                        <button type="submit" name="add">Inserir</button>
                    </form>
                </div>
                <div class="filterBill">
                    <h1>Filtros para buscar contas</h1>
                    <form method="get">
                        <div class="formsIpunt">
                            <label for="empresa">Empresa:</label>
                            <input type="text" name="empresa" id="empresa" value="<?= htmlspecialchars($filter_companies) ?>">
                        </div>
                    
                        <div class="formsIpunt">
                            <label for="valor_operador">Operador do:</label>
                            <select name="valor_operador" id="valor_operador">
                                <option value=">">Maior que</option>
                                <option value="<">Menor que</option>
                                <option value="=">Igual a</option>
                            </select>
                        </div>
            
                        <div class="formsIpunt">
                            <label for="valor">Valor:</label>
                            <input type="text" name="valor" id="valor" value="<?= htmlspecialchars($filter_value) ?>">
                        </div>
            
                        <div class="formsIpunt">
                            <label for="data">Data de Pagamento:</label>
                            <input type="date" name="data" id="data" value="<?= htmlspecialchars($filter_date) ?>">
                        </div>
            
                        <button type="submit">Filtrar</button>
                    </form>
                </div>
            </div>
            <table>
                <tr>
                    <th>Empresa</th>
                    <th>Valor</th>
                    <th>Data a Pagar</th>
                    <th>Pago</th>
                    <th class="actions">Ações</th>
                </tr>
                <?php while ($row = $bills->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nome'] ?></td>
                        <td><?= format_value($row['valor']) ?></td>
                        <td><?=(new DateTime($row['data_pagar']))->format('d/m/Y') ?></td>
                        <td><?= $row['pago'] ? 'Sim' : 'Não' ?>
                        </td>
                        <td class="actions">
                            <a href="?paid=<?= $row['id_conta_pagar'] ?>" data-paid=<?= $row['pago'] ? 'Sim' : 'Não' ?> class="pay">Pagar</a>
                            <a href="editBill.php?idBill=<?= $row['id_conta_pagar']?>">Editar</a>
                            <a href="?delete=<?= $row['id_conta_pagar'] ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </body>
    <script src='src/js/script.js'></script>
</html>