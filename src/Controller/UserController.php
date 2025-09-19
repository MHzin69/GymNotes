<?php
namespace Src\Model;

use PDO;
use PDOException;
use Exception;

final class Database {
    private static ?string $host = null;
    private static ?string $db   = null;
    private static ?string $user = null;
    private static ?string $pass = null;

    private static ?PDO $conn = null;

    private static function loadAndValidateConfig(): void {
        self::$host = getenv('DB_HOST') ?: 'localhost';
        self::$db   = getenv('DB_NAME') ?: 'academia';
        self::$user = getenv('DB_USER') ?: 'root';
        self::$pass = getenv('DB_PASS') ?: '';

        if (empty(self::$host) || empty(self::$db) || empty(self::$user)) {
            error_log("FATAL: Variáveis de ambiente do banco não estão configuradas corretamente.");
            throw new Exception("Erro de configuração interna do servidor.");
        }
    }

    public static function connect(): PDO {
        if (self::$conn === null) {
            self::loadAndValidateConfig();

            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$conn = new PDO($dsn, self::$user, self::$pass, $options);

            } catch (PDOException $e) {
                error_log("Erro de conexão PDO: " . $e->getMessage());
                throw new Exception("Erro interno ao conectar no banco.");
            }
        }
        return self::$conn;
    }

    public static function disconnect(): void {
        self::$conn = null;
    }

    private function __construct() {}
    private function __clone() {}
}
