<?php

class Database
{
    private static string $servername = "localhost";
    private static string $username = "root";
    private static string $password = "";
    private static string $dbname = "bookStore_db";
    private static string $charset = "utf8mb4";
    private static ?PDO $conn = null;

    private function __construct() {}

    public static function connect(): PDO
    {
        if (self::$conn === null) {
        $dsn = "mysql:host=" . self::$servername .
            ";dbname=" . self::$dbname .
            ";charset=" . self::$charset;

        self::$conn = new PDO($dsn, self::$username, self::$password);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$conn;
    }
}
