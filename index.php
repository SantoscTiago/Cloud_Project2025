<?php
require_once __DIR__ . '/mysqli_connect.php';
require_once __DIR__ . '/db_queries.php';
$error_message = $db_error;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Motas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        form { display: inline; }
        .form-section { margin-bottom: 30px; }
        .btn { padding: 5px 10px; margin: 2px; cursor: pointer; }
        .btn-add { background-color: #4CAF50; color: white; border: none; }
        .btn-delete { background-color: #f44336; color: white; border: none; }
        .btn-edit { background-color: #ff9800; color: white; border: none; }
    </style>
</head>
<body>

<h1>Catálogo de Motas</h1>

<?php if ($error_message): ?>
    <div style="color: red;">Erro na ligação à base de dados: <?= htmlspecialchars($error_message) ?></div>
<?php endif; ?>

<!-- Formulário Adicionar/Editar -->
<div class="form-section">
    <h2>Adicionar Nova Mota</h2>
    <form method="post" action="index.php">
        <input type="hidden" name="id" value="<?= isset($mota_editar) ? $mota_editar['id'] : '' ?>">

        <label>Marca: <input type="text" name="marca" required value="<?= isset($mota_editar) ? $mota_editar['marca'] : '' ?>"></label><br><br>
        <label>Modelo: <input type="text" name="modelo" required value="<?= isset($mota_editar) ? $mota_editar['modelo'] : '' ?>"></label><br><br>
        <label>Cilindrada (cc): <input type="number" name="cilindrada" required value="<?= isset($mota_editar) ? $mota_editar['cilindrada'] : '' ?>"></label><br><br>
        <label>Preço (€): <input type="number" step="0.01" name="preco" required value="<?= isset($mota_editar) ? $mota_editar['preco'] : '' ?>"></label><br><br>
        <label>Ano: <input type="number" name="ano" required value="<?= isset($mota_editar) ? $mota_editar['ano'] : '' ?>"></label><br><br>
        <label>Tipo: <input type="text" name="tipo" required value="<?= isset($mota_editar) ? $mota_editar['tipo'] : '' ?>"></label><br><br>

        <button type="submit" name="<?= isset($mota_editar) ? 'guardar_editar' : 'adicionar' ?>" class="btn btn-add">
            <?= isset($mota_editar) ? 'Guardar Alterações' : 'Adicionar Mota' ?>
        </button>
    </form>
</div>

<!-- Tabela de Motas -->
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Cilindrada</th>
        <th>Preço (€)</th>
        <th>Ano</th>
        <th>Tipo</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($motas as $mota): ?>
        <tr>
            <td><?= htmlspecialchars($mota['id']) ?></td>
            <td><?= htmlspecialchars($mota['marca']) ?></td>
            <td><?= htmlspecialchars($mota['modelo']) ?></td>
            <td><?= htmlspecialchars($mota['cilindrada']) ?></td>
            <td><?= htmlspecialchars($mota['preco']) ?></td>
            <td><?= htmlspecialchars($mota['ano']) ?></td>
            <td><?= htmlspecialchars($mota['tipo']) ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $mota['id'] ?>">
                    <button type="submit" name="apagar" class="btn btn-delete">Apagar</button>
                </form>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $mota['id'] ?>">
                    <button type="submit" name="guardar_editar" class="btn btn-edit">Editar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
