<?php
$db_error = null;
$host = '10.0.2.4';  // IP privado da VM MySQL
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=motas_bd;charset=$charset";

try {
    $pdo = new PDO($dsn, "root", "1234567");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $db_error = $e->getMessage();
    $pdo = null;
}
?>
