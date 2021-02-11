<?php
namespace Service;

use Repository\Page as PageRepository;

/**
 * Class Page
 * @package Service
 */
class Page extends Service {

    /**
     * Page constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $repository = new PageRepository($db);
        parent::__construct($db, $repository, 'page');
    }

    /**
     * @param string|int $flyerId
     * @return array
     */
    public function getAllByFlyerId($flyerId): array
    {
        $result = $this->repository->findAllByFlyerId( (int) $flyerId);

        foreach ($result as $key => $page) {
            $result[$key] = $this->parseResponse($page);
        }

        $response['status_code'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);

        return $response;
    }
}
