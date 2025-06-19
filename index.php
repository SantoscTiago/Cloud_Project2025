<?php
    require_once __DIR__ . '/mysqli_connect.php';
    require_once __DIR__ . '/db_queries.php';
    $error_message = $db_error;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Motas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Motas</h1>

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
                <th>Cilindrada (cc)</th>
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
                            <button type="submit" name="apagar" class="btn btn-danger btn-sm">Apagar</button>
                        </form>
                        <button type="button" class="btn btn-warning btn-sm"
                                data-toggle="modal"
                                data-target="#editModal"
                                data-id="<?= $mota['id'] ?>"
                                data-marca="<?= htmlspecialchars($mota['marca']) ?>"
                                data-modelo="<?= htmlspecialchars($mota['modelo']) ?>"
                                data-cilindrada="<?= htmlspecialchars($mota['cilindrada']) ?>"
                                data-preco="<?= htmlspecialchars($mota['preco']) ?>"
                                data-ano="<?= htmlspecialchars($mota['ano']) ?>"
                                data-tipo="<?= htmlspecialchars($mota['tipo']) ?>">
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
                        <label>Cilindrada</label>
                        <input type="text" name="cilindrada" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Preço (€)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ano</label>
                        <input type="number" name="ano" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo</label>
                        <input type="text" name="tipo" class="form-control" required>
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
                    <h5 class="modal-title">Editar Motas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label>Marca</label>
                        <input type="text" name="marca" id="edit-marca" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Modelo</label>
                        <input type="text" name="modelo" id="edit-modelo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Cilindrada</label>
                        <input type="text" name="cilindrada" id="edit-cilindrada" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Preço (€)</label>
                        <input type="number" step="0.01" name="preco" id="edit-preco" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ano</label>
                        <input type="number" name="ano" id="edit-ano" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo</label>
                        <input type="text" name="tipo" id="edit-tipo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="guardar_editar" class="btn btn-primary">Guardar Alterações</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts Bootstrap e JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#edit-id').val(button.data('id'));
        $('#edit-marca').val(button.data('marca'));
        $('#edit-modelo').val(button.data('modelo'));
        $('#edit-cilindrada').val(button.data('cilindrada'));
        $('#edit-preco').val(button.data('preco'));
        $('#edit-ano').val(button.data('ano'));
        $('#edit-tipo').val(button.data('tipo'));
    });
</script>
</body>
</html>
