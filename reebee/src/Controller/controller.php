<?php
namespace Controller;

use Middleware\Auth;

/**
 * Class Controller
 * @package Controller
 */
class Controller {

    protected $service;
    protected $requestMethod;
    protected $param;

    /**
     * Controller constructor.
     * @param \Service\Flyer|\Service\Page|\Service\User $service
     * @param string $requestMethod
     * @param string|null $param
     */
    public function __construct($service, string $requestMethod, string $param = null)
    {
        $this->service = $service;
        $this->requestMethod = $requestMethod;
        $this->param = $param;
    }

    /**
     * @return array
     */
    public function processRequest(): array
    {
        if ($this->requestMethod != 'GET') {
            $denied = (new Auth($this->service->db))->run();
            if ($denied)
                return $denied;
        }

        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->get();
                break;
            case 'POST':
                $response = $this->post();
                break;
            case 'PUT':
                $response = $this->put();
                break;
            case 'DELETE':
                $response = $this->delete();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        return $response;
    }

    /**
     * @return array
     */
    protected function get(): array
    {
        if ($this->param) {
            $response = $this->service->getItem($this->param);
        } else {
            $response = $this->service->getAll();
        }

        return $response;
    }

    /**
     * @return array
     */
    protected function post(): array
    {
        $data = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (!$this->validate($data)) {
            return $this->unprocessableEntityResponse();
        }
        $response = $this->service->create($data);

        return $response;
    }

    /**
     * @return array
     */
    protected function put(): array
    {
        $data = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validate($data)) {
            return $this->unprocessableEntityResponse();
        }
        $response = $this->service->update($this->param, $data);

        return $response;
    }

    /**
     * @return array
     */
    protected function delete(): array
    {
        $this->service->delete($this->param);
        $response['status_code'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;

        return $response;
    }

    /**
     * @param string|null $message
     * @return array
     */
    protected function unprocessableEntityResponse(string $message = null): array
    {
        $response['status_code'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => $message ?? 'Invalid input data'
        ]);

        return $response;
    }

    /**
     * @return array
     */
    protected function notFoundResponse(): array
    {
        $response['status_code'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;

        return $response;
    }
}
