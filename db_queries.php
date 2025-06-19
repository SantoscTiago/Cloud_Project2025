<?php
require_once __DIR__ . '/mysqli_connect.php'; // Este ficheiro deve definir $pdo com PDO

$motas = [];
if ($pdo !== null) {
    try {
        $sql = "SELECT id, marca, modelo, cilindrada, preco, ano, tipo FROM motas";
        $stmt = $pdo->query($sql);
        $motas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $db_error = $e->getMessage();
    }
}

function listar_motas(): array {
    global $pdo;
    if ($pdo === null) return [];

    try {
        $sql = "SELECT id, marca, modelo, cilindrada, preco, ano, tipo FROM motas ORDER BY id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
function obter_mota_por_id($id) {
    global $pdo;
    if ($pdo === null) return null;

    try {
        $sql = "SELECT * FROM motas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}
function atualizar_mota($dados) {
    global $pdo;
    if ($pdo === null) return;

    try {
        $sql = "UPDATE motas SET 
                    marca = :marca,
                    modelo = :modelo,
                    cilindrada = :cilindrada,
                    preco = :preco,
                    ano = :ano,
                    tipo = :tipo
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':marca' => $dados['marca'],
            ':modelo' => $dados['modelo'],
            ':cilindrada' => $dados['cilindrada'],
            ':preco' => $dados['preco'],
            ':ano' => $dados['ano'],
            ':tipo' => $dados['tipo'],
            ':id' => $dados['id']
        ]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao editar: " . $e->getMessage();
    }
}
function adicionar_mota($dados) {
    global $pdo;
    if ($pdo === null) return;

    try {
        $sql = "INSERT INTO motas (marca, modelo, cilindrada, preco, ano, tipo) 
                VALUES (:marca, :modelo, :cilindrada, :preco, :ano, :tipo)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':marca' => $dados['marca'],
            ':modelo' => $dados['modelo'],
            ':cilindrada' => $dados['cilindrada'],
            ':preco' => $dados['preco'],
            ':ano' => $dados['ano'],
            ':tipo' => $dados['tipo']
        ]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao adicionar: " . $e->getMessage();
    }
}

function apagar_mota($id) {
    global $pdo;
    if ($pdo === null) return;

    try {
        $sql = "DELETE FROM motas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao apagar: " . $e->getMessage();
    }
}



//funçoes antigas
// ADICIONAR
if (isset($_POST['adicionar']) && $pdo !== null) {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $cilindrada = $_POST['cilindrada'];
    $preco = $_POST['preco'];
    $ano = $_POST['ano'];
    $tipo = $_POST['tipo'];

    try {
        $sql = "INSERT INTO motas (marca, modelo, cilindrada, preco, ano, tipo) 
                VALUES (:marca, :modelo, :cilindrada, :preco, :ano, :tipo)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':cilindrada' => $cilindrada,
            ':preco' => $preco,
            ':ano' => $ano,
            ':tipo' => $tipo
        ]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao adicionar: " . $e->getMessage();
    }
} elseif (isset($_POST['adicionar'])) {
    $db_error = $db_error ?: 'Ligação à base de dados indisponível';
}

// APAGAR
if (isset($_POST['apagar']) && $pdo !== null) {
    $id = $_POST['id'];
    try {
        $sql = "DELETE FROM motas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao apagar: " . $e->getMessage();
    }
} elseif (isset($_POST['apagar'])) {
    $db_error = $db_error ?: 'Ligação à base de dados indisponível';
}


// EDITAR
if (isset($_POST['guardar_editar']) && $pdo !== null) {
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $cilindrada = $_POST['cilindrada'];
    $preco = $_POST['preco'];
    $ano = $_POST['ano'];
    $tipo = $_POST['tipo'];

    try {
        $sql = "UPDATE motas SET 
                    marca = :marca,
                    modelo = :modelo,
                    cilindrada = :cilindrada,
                    preco = :preco,
                    ano = :ano,
                    tipo = :tipo
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':cilindrada' => $cilindrada,
            ':preco' => $preco,
            ':ano' => $ano,
            ':tipo' => $tipo,
            ':id' => $id
        ]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao editar: " . $e->getMessage();
    }
} elseif (isset($_POST['guardar_editar'])) {
    $db_error = $db_error ?: 'Ligação à base de dados indisponível';
}
?>
