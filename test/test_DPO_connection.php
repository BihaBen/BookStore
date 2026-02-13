<?php
require_once __DIR__ . '/../src/Database/Connection.php';

try {
    $pdo = Connection::connect();
    $tables = $pdo->query("SHOW TABLES")->fetchAll();

    # Kiírások a fejlesztőnek:
    echo "Az adatbázishoz sikeresen megtörtént a csatlakozás:\n";
    echo "<pre>";
    print_r($tables);
    echo "</pre>";
    
} catch (PDOException $e) {
    echo "ConnectionSikertelen: " . htmlspecialchars($e->getMessage());
}