<?php
require_once __DIR__ . '/mysqli_connect.php';
require_once __DIR__ . '/db_queries.php';
$error_message = $db_error;

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        $id_editar = (int) $_POST['id'];
        $mota_editar = obter_mota_por_id($id_editar);
    } elseif (isset($_POST['guardar_editar'])) {
        atualizar_mota($_POST);
    } elseif (isset($_POST['adicionar'])) {
        adicionar_mota($_POST);
    } elseif (isset($_POST['apagar'])) {
        apagar_mota((int)$_POST['id']);
    }
}

// Listar todas as motas
$motas = listar_motas();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Motas</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #222;
        }

        .container {
            max-width: 960px;
            margin: auto;
        }

        .form-section {
            background-color: #fff;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 12px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button.btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-add { background-color: #4CAF50; color: white; }
        .btn-edit { background-color: #ff9800; color: white; }
        .btn-delete { background-color: #f44336; color: white; }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Catálogo de Motas</h1>

    <?php if ($error_message): ?>
        <div class="error">Erro na ligação à base de dados: <?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <!-- Formulário -->
    <div class="form-section">
        <h2><?= isset($mota_editar) ? 'Editar Mota' : 'Adicionar Nova Mota' ?></h2>
        <form method="post" action="index.php">
            <input type="hidden" name="id" value="<?= isset($mota_editar) ? $mota_editar['id'] : '' ?>">

            <label>Marca:
                <input type="text" name="marca" required value="<?= isset($mota_editar) ? $mota_editar['marca'] : '' ?>">
            </label>

            <label>Modelo:
                <input type="text" name="modelo" required value="<?= isset($mota_editar) ? $mota_editar['modelo'] : '' ?>">
            </label>

            <label>Cilindrada (cc):
                <input type="number" name="cilindrada" required value="<?= isset($mota_editar) ? $mota_editar['cilindrada'] : '' ?>">
            </label>

            <label>Preço (€):
                <input type="number" step="0.01" name="preco" required value="<?= isset($mota_editar) ? $mota_editar['preco'] : '' ?>">
            </label>

            <label>Ano:
                <input type="number" name="ano" required value="<?= isset($mota_editar) ? $mota_editar['ano'] : '' ?>">
            </label>

            <label>Tipo:
                <input type="text" name="tipo" required value="<?= isset($mota_editar) ? $mota_editar['tipo'] : '' ?>">
            </label>

            <br>
            <button type="submit" name="<?= isset($mota_editar) ? 'guardar_editar' : 'adicionar' ?>" class="btn btn-add">
                <?= isset($mota_editar) ? 'Guardar Alterações' : 'Adicionar Mota' ?>
            </button>
        </form>
    </div>

    <!-- Tabela -->
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
                    <td class="actions">
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $mota['id'] ?>">
                            <button type="submit" name="editar" class="btn btn-edit">Editar</button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $mota['id'] ?>">
                            <button type="submit" name="apagar" class="btn btn-delete" onclick="return confirm('Tem a certeza que deseja apagar esta mota?')">Apagar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
