<?php
namespace Service;

use Repository\User as UserRepository;

/**
 * Class User
 * @package Service
 */
class User {

    private $repository;

    /**
     * User constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->repository = new UserRepository($db);
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        $result = $this->repository->findAll();

        $response = $this->parseResponse($result);

        return $response;
    }

    /**
     * @param array $user
     * @return array
     */
    public function create(array $user): array
    {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $this->repository->insert($user);
        $response['status_code'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;

        return $response;
    }

    /**
     * @param array $users
     * @return array
     */
    private function parseResponse(array $users): array
    {
        $response = [];
        foreach ($users as $user) {
            $response[$user['username']] = $user['password'];
        }

        return $response;
    }
}
