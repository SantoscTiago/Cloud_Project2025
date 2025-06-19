<?php
require_once __DIR__ . '/mysqli_connect.php';

$db_error = '';
$motas = [];

// Verificar ligação
if ($mysqli->connect_error) {
    $db_error = "Erro de ligação: " . $mysqli->connect_error;
} else {
    // Adicionar Mota
    if (isset($_POST['adicionar'])) {
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $cilindrada = $_POST['cilindrada'];
        $preco = $_POST['preco'];
        $ano = $_POST['ano'];
        $tipo = $_POST['tipo'];

        $stmt = $mysqli->prepare("INSERT INTO motas (marca, modelo, cilindrada, preco, ano, tipo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssdis', $marca, $modelo, $cilindrada, $preco, $ano, $tipo);

        if (!$stmt->execute()) {
            $db_error = "Erro ao adicionar mota: " . $stmt->error;
        }
        $stmt->close();
        header("Location: index.php");
        exit();
    }

    // Editar Mota
    if (isset($_POST['guardar_editar'])) {
        $id = $_POST['id'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $cilindrada = $_POST['cilindrada'];
        $preco = $_POST['preco'];
        $ano = $_POST['ano'];
        $tipo = $_POST['tipo'];

        $stmt = $mysqli->prepare("UPDATE motas SET marca=?, modelo=?, cilindrada=?, preco=?, ano=?, tipo=? WHERE id=?");
        $stmt->bind_param('sssdssi', $marca, $modelo, $cilindrada, $preco, $ano, $tipo, $id);

        if (!$stmt->execute()) {
            $db_error = "Erro ao editar mota: " . $stmt->error;
        }
        $stmt->close();
        header("Location: index.php");
        exit();
    }

    // Apagar Mota
    if (isset($_POST['apagar'])) {
        $id = $_POST['id'];

        $stmt = $mysqli->prepare("DELETE FROM motas WHERE id=?");
        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            $db_error = "Erro ao apagar mota: " . $stmt->error;
        }
        $stmt->close();
        header("Location: index.php");
        exit();
    }

    // Listar Motas
    $result = $mysqli->query("SELECT * FROM motas ORDER BY id ASC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $motas[] = $row;
        }
        $result->free();
    } else {
        $db_error = "Erro ao obter motas: " . $mysqli->error;
    }
}

$mysqli->close();
?>
