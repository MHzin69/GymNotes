<?php
namespace Src\Model;

use PDO;
use PDOException;

class Database {
    private static ?PDO $conn = null;

    public static function getConnection(): PDO {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=127.0.0.1;port=3306;dbname=gymnotes;charset=utf8",
                    "root",
                    "1234" // <-- aqui vai a senha que você configurou
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}