<?php
namespace Controller;

use Service\User as UserService;

/**
 * Class User
 * @package Controller
 */
class User extends Controller {

    private $token;

    /**
     * User constructor.
     * @param UserService $service
     * @param string $requestMethod
     */
    public function __construct(UserService $service, string $requestMethod)
    {
        parent::__construct($service, $requestMethod);
        $this->token = getenv('TOKEN');
    }

    /**
     * @return array
     */
    public function processRequest(): array
    {
        if (!$this->validateToken()) {
            return $this->unprocessableEntityResponse("Token is invalid.");
        }

        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->post();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        return $response;
    }

    /**
     * @return bool
     */
    private function validateToken(): bool
    {
        $headers = getallheaders();
        if (array_key_exists('Token', $headers) && $headers['Token'] == $this->token) {
            return true;
        }

        return false;
    }

    /**
     * @param array $user
     * @return bool
     */
    protected function validate(array $user): bool
    {
        if (!isset($user['username']) || empty($user['username'])) {
            return false;
        }
        if (!isset($user['password']) || empty($user['password'])) {
            return false;
        }

        return true;
    }
}
