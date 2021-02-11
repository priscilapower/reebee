<?php
namespace Repository;

/**
 * Class Page
 * @package Repository
 */
class Page {

    private $db;

    /**
     * Page constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $flyer_id
     * @return array|null
     */
    public function findAllByFlyerId(int $flyer_id): ?array
    {
        $statement = "
            SELECT id, date_valid, date_expired, page_number, flyer_id
            FROM page
            WHERE flyer_id = :flyer_id
            ORDER BY page_number";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(['flyer_id' => $flyer_id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return $result;

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function find(int $id): ?array
    {
        $statement = "SELECT id, date_valid, date_expired, page_number, flyer_id FROM page WHERE id = :id";

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
     * @param array $page
     * @return int|null
     */
    public function insert(array $page): ?int
    {
        $statement = "
            INSERT INTO page (date_valid, date_expired, page_number, flyer_id)
            VALUES (:date_valid, :date_expired, :page_number, :flyer_id)
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'date_valid' => $page['dateValid'],
                'date_expired' => $page['dateExpired'],
                'page_number' => $page['pageNumber'],
                'flyer_id' => $page['flyerId']
            ]);

            return $statement->rowCount();

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param array $page
     * @return int|null
     */
    public function update(int $id, array $page): ?int
    {
        $statement = "
            UPDATE page SET 
                date_valid = :date_valid,
                date_expired = :date_expired,
                page_number = :page_number,
                flyer_id = :flyer_id
            WHERE id = :id
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'id' => (int) $id,
                'date_valid' => $page['dateValid'],
                'date_expired' => $page['dateExpired'],
                'page_number' => $page['pageNumber'],
                'flyer_id' => $page['flyerId']
            ]);

            return $statement->rowCount();

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return int|null
     */
    public function delete(int $id): ?int
    {
        $statement = "DELETE FROM page WHERE id = :id";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(['id' => $id]);

            return $statement->rowCount();

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}