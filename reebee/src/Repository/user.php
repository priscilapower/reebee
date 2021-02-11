<?php
namespace Repository;

/**
 * Class User
 * @package Repository
 */
class User {

    private $db;

    /**
     * User constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @return array|null
     */
    public function findAll(): ?array
    {
        $statement = "SELECT username, password FROM user";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $result;

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param array $user
     * @return int|null
     */
    public function insert(array $user): ?int
    {
        $statement = "
            INSERT INTO user (name, username, password)
            VALUES (:name, :username, :password)
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'name' => isset($user['name']) ? $user['name'] : null,
                'username'  => $user['username'],
                'password' => $user['password']
            ]);

            return $statement->rowCount();

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}