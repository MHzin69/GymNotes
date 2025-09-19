<?php
namespace Src\Model;

use PDO;
use PDOException;

class Database {
    private static string $host = "localhost";
    private static string $db   = "academia";
    private static string $user = "root";
    private static string $pass = "";
    private static ?PDO $conn = null;

    public static function connect(): PDO {
        if (self::$conn === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=utf8";
                self::$conn = new PDO($dsn, self::$user, self::$pass);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new PDOException("Erro ao conectar ao banco: " . $e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$conn;
    }

    public static function disconnect(): void {
        self::$conn = null;
    }
}
