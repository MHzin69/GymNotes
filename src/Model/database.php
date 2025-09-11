<?php
namespace Src\Model;

use PDO;
use PDOException;

class Database {
    private static $host = "localhost";
    private static $db   = "gymnotes";
    private static $user = "root";
    private static $pass = "";
    private static $conn;

    public static function connect() {
        if (self::$conn == null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db,
                    self::$user,
                    self::$pass
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
