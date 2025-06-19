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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Catálogo de Motas</h1>

    <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            Erro na ligação à base de dados: <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <!-- Botão Adicionar -->
    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal">Adicionar Mota</button>

    <!-- Tabela -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Preço (€)</th>
                <th>Cilindrada (cc)</th>
                <th>Peso (kg)</th>
                <th>Tipo de Motor</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($motas as $mota): ?>
                <tr>
                    <td><?= htmlspecialchars($mota['id']) ?></td>
                    <td><?= htmlspecialchars($mota['marca']) ?></td>
                    <td><?= htmlspecialchars($mota['modelo']) ?></td>
                    <td><?= htmlspecialchars($mota['preco']) ?></td>
                    <td><?= htmlspecialchars($mota['cilindrada']) ?></td>
                    <td><?= htmlspecialchars($mota['peso']) ?></td>
                    <td><?= htmlspecialchars($mota['tipo_motor']) ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $mota['id'] ?>">
                            <button type="submit" name="apagar" class="btn btn-danger btn-sm">Apagar</button>
                        </form>
                        <button type="button" class="btn btn-warning btn-sm"
                                data-toggle="modal"
                                data-target="#editModal"
                                data-id="<?= $mota['id'] ?>"
                                data-marca="<?= htmlspecialchars($mota['marca']) ?>"
                                data-modelo="<?= htmlspecialchars($mota['modelo']) ?>"
                                data-preco="<?= $mota['preco'] ?>"
                                data-cilindrada="<?= $mota['cilindrada'] ?>"
                                data-peso="<?= $mota['peso'] ?>"
                                data-motor="<?= htmlspecialchars($mota['tipo_motor']) ?>">
                            Editar
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Adicionar -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="index.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Mota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Marca</label>
                        <input type="text" name="marca" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Modelo</label>
                        <input type="text" name="modelo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Preço (€)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Cilindrada (cc)</label>
                        <input type="number" name="cilindrada" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Peso (kg)</label>
                        <input type="number" name="peso" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Motor</label>
                        <input type="text" name="tipo_motor" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="adicionar" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="index.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Mota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label>Marca</label>
                        <input type="text" name="marca" id="edit-marca" class="form-control" req
