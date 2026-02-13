<?php
require_once __DIR__ . '/../src/Database/BookStoreDatabase.php';

try {
    $pdo = Database::connect();
    $tables = $pdo->query("SHOW TABLES")->fetchAll();

    # Kiírások a fejlesztőnek:
    echo "Az adatbázishoz sikeresen megtörtént a csatlakozás:\n";
    echo "<pre>";
    print_r($tables);
    echo "</pre>";
    
    # Singleton pattern ellenőrzése
    $pdo1 = Database::connect();
    $pdo2 = Database::connect();
    if ($pdo1 === $pdo2){
        echo "A singleton pattern alkalmazása sikeres volt:<br>";
    }
    else{
        echo "A singleton pattern alkalmazása sikertelen volt:<br>";
    }
    
    echo "1. PDO ID:". spl_object_id($pdo1) . "<br>";
    echo "2.) PDO ID:". spl_object_id($pdo2);
        

} catch (PDOException $e) {
    echo "ConnectionSikertelen: " . htmlspecialchars($e->getMessage());
}