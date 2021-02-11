<?php
namespace Service;

use Repository\Flyer as FlyerRepository;

/**
 * Class Flyer
 * @package Service
 */
class Flyer extends Service {

    /**
     * Flyer constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $repository = new FlyerRepository($db);
        parent::__construct($db, $repository, 'flyer');
    }
}
