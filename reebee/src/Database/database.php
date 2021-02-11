<?php
namespace Database;

/**
 * Class Database
 * @package Database
 */
class Database {

    private $conn = null;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $host = getenv('MYSQL_ALIAS');
        $db   = getenv('MYSQL_DATABASE');
        $user = getenv('MYSQL_USER');
        $pass = getenv('MYSQL_PASSWORD');

        try {
            $this->conn = new \PDO(
                sprintf("mysql:host=%s;dbname=%s;charset=utf8mb4", $host, $db),
                $user,
                $pass,
                [
                    \PDO::ATTR_STRINGIFY_FETCHES => false,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @return \PDO|null
     */
    public function getConnection()
    {
        return $this->conn;
    }
}
