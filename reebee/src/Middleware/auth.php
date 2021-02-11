<?php
namespace Middleware;

use Service\User;

/**
 * Class Auth
 * @package Middleware
 */
class Auth{
    private $service;
    private $users;
    private $username;
    private $password;

    /**
     * Auth constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->service = new User($db);
        $this->users = $this->service->getUsers();
        $this->username = $_SERVER['PHP_AUTH_USER'] ?? null;
        $this->password = $_SERVER['PHP_AUTH_PW'];
    }

    /**
     * @return array|null
     */
    public function run(): ?array
    {
        if (!$this->validateLogin()) {
            $response['status_code'] = 'HTTP/1.1 401 Unauthorized';
            $response['body'] = "Access denied.";

            return $response;
        }

        return null;
    }

    /**
     * @return bool
     */
    private function validateLogin(): bool
    {
        if (!empty($this->username) && !empty($this->password) && array_key_exists($this->username, $this->users)
            && password_verify($this->password, $this->users[$this->username])) {
            return true;
        }

        return false;
    }
}
