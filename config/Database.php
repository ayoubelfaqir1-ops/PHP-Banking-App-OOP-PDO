<?php
namespace Config;
use PDO;
use PDOException;
use RuntimeException;
class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    "mysql:host=localhost;dbname=App_bancaire;charset=utf8mb4",
                    "root",
                    "",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                throw new RuntimeException(
                    "Database connection failed. Please try again later."
                );
            }
        }

        return self::$pdo;
    }
}
?>