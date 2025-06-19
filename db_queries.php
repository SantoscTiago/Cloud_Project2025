<?php
require 'mysqli_connect.php';  // ou outro nome do ficheiro da ligação

// Exibir erro se ligação falhar
if ($pdo === null) {
    die("Erro de ligação à base de dados: " . ($db_error ?? 'Desconhecido'));
}

// INSERIR
if (isset($_POST['guardar'])) {
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $cilindrada = $_POST['cilindrada'] ?? 0;
    $preco = $_POST['preco'] ?? 0;
    $ano = $_POST['ano'] ?? 0;
    $tipo = $_POST['tipo'] ?? '';

    $sql = "INSERT INTO motas (marca, modelo, cilindrada, preco, ano, tipo) 
            VALUES (:marca, :modelo, :cilindrada, :preco, :ano, :tipo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':marca' => $marca,
        ':modelo' => $modelo,
        ':cilindrada' => $cilindrada,
        ':preco' => $preco,
        ':ano' => $ano,
        ':tipo' => $tipo,
    ]);

    header("Location: index.php");
    exit;
}

// ALTERAR
if (isset($_POST['alterar'])) {
    $id = $_POST['id'] ?? 0;
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $cilindrada = $_POST['cilindrada'] ?? 0;
    $preco = $_POST['preco'] ?? 0;
    $ano = $_POST['ano'] ?? 0;
    $tipo = $_POST['tipo'] ?? '';

    $sql = "UPDATE motas SET marca=:marca, modelo=:modelo, cilindrada=:cilindrada,
            preco=:preco, ano=:ano, tipo=:tipo WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':marca' => $marca,
        ':modelo' => $modelo,
        ':cilindrada' => $cilindrada,
        ':preco' => $preco,
        ':ano' => $ano,
        ':tipo' => $tipo,
        ':id' => $id,
    ]);

    header("Location: index.php");
    exit;
}

// APAGAR
if (isset($_POST['apagar'])) {
    $id = $_POST['id'] ?? 0;

    $sql = "DELETE FROM motas WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    header("Location: index.php");
    exit;
}

// Mostrar dados
$sql = "SELECT * FROM motas";
$stmt = $pdo->query($sql);
$motas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
