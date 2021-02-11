<?php
namespace Repository;

/**
 * Class Repository
 * @package Repository
 */
class Repository {

    protected $db;

    /**
     * Repository constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
}
