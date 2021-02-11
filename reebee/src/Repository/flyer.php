<?php
namespace Repository;

/**
 * Class Flyer
 * @package Repository
 */
class Flyer extends Repository{

     /**
     * @return array|null
     */
    public function findAll(): ?array
    {
        $statement = "
            SELECT id, name, store_name, date_valid, date_expired, page_count
            FROM flyer
            WHERE date_expired >= CURDATE()";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $result;

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        $statement = "SELECT id, name, store_name, date_valid, date_expired, page_count FROM flyer WHERE id = :id";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(['id' => $id]);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            $result = !is_bool($result) ? $result : [];

            return $result;

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param array $flyer
     * @return array|null
     */
    public function insert(array $flyer): ?int
    {
        $statement = "
            INSERT INTO flyer (name, store_name, date_valid, date_expired, page_count)
            VALUES (:name, :store_name, :date_valid, :date_expired, :page_count)
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'name' => $flyer['name'],
                'store_name'  => $flyer['storeName'],
                'date_valid' => $flyer['dateValid'],
                'date_expired' => $flyer['dateExpired'],
                'page_count' => $flyer['pageCount']
            ]);

            return $statement->rowCount();

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param array $flyer
     * @return array|null
     */
    public function update(int $id, Array $flyer): ?int
    {
        $statement = "
            UPDATE flyer SET 
                name = :name,
                store_name  = :store_name,
                date_valid = :date_valid,
                date_expired = :date_expired,
                page_count = :page_count
            WHERE id = :id
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'id' => (int) $id,
                'name' => $flyer['name'],
                'store_name'  => $flyer['storeName'],
                'date_valid' => $flyer['dateValid'],
                'date_expired' => $flyer['dateExpired'],
                'page_count' => $flyer['pageCount']
            ]);

            return $statement->rowCount();

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function delete(int $id): ?int
    {
        $statement = "DELETE FROM flyer WHERE id = :id";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(['id' => $id]);

            return $statement->rowCount();

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
