<?php
namespace Service;

/**
 * Class Service
 * @package Service
 */
class Service {

    protected $repository;
    protected $name;
    public $db;

    /**
     * Service constructor.
     * @param \PDO $db
     * @param \Repository\Flyer|\Repository\Page $repository
     * @param string $name
     */
    public function __construct(\PDO $db, $repository, string $name)
    {
        $this->db = $db;
        $this->repository = $repository;
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $result = $this->repository->findAll();

        foreach ($result as $key => $flyer) {
            $result[$key] = $this->parseResponse($flyer);
        }

        $response['status_code'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);

        return $response;
    }

    /**
     * @param string|int $id
     * @return array
     */
    public function getItem($id): array
    {
        $result = $this->repository->find((int) $id);
        if (!$result) {
            return $this->notFoundResponse();
        }

        $parsed = $this->parseResponse($result);
        $response['status_code'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($parsed);

        return $response;
    }

    /**
     * @param array $item
     * @return array
     */
    public function create(array $item): array
    {
        $this->repository->insert($item);
        $response['status_code'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;

        return $response;
    }

    /**
     * @param string|int $id
     * @param array $item
     * @return array
     */
    public function update($id, array $item): array
    {
        $result = $this->repository->find((int) $id);
        if (!$result) {
            return $this->notFoundResponse();
        }

        $this->repository->update($id, $item);
        $response['status_code'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;

        return $response;
    }

    /**
     * @param string|int $id
     * @return array
     */
    public function delete($id): array
    {
        $result = $this->repository->find((int) $id);
        if (!$result) {
            return $this->notFoundResponse();
        }

        $this->repository->delete((int) $id);
        $response['status_code'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;

        return $response;
    }

    /**
     * @param array $response
     * @return array
     */
    protected function parseResponse(array $response): array
    {
        $parsed = [];
        array_map(function ($key, $value) use (&$parsed) {
            $key = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            $key = ($key == 'id') ? $this->name."ID" : $key;
            $parsed[$key] = $value;
        }, array_keys($response), $response);

        return $parsed;
    }

    /**
     * @return array
     */
    private function notFoundResponse(): array
    {
        $response['status_code'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;

        return $response;
    }
}
