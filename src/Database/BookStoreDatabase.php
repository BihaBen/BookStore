<?php

class Database
{
    private static string $servername = "localhost";
    private static string $username = "root";
    private static string $password = "";
    private static string $dbname = "bookStore_db";
    private static string $charset = "utf8mb4";

    public static function connect(): PDO
    {
        $dsn = "mysql:host=" . self::$servername .
            ";dbname=" . self::$dbname .
            ";charset=" . self::$charset;

        $conn = new PDO($dsn, self::$username, self::$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
