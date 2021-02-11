<?php
namespace Controller;

use Service\Page as PageService;

/**
 * Class Page
 * @package Controller
 */
class Page extends Controller {

    private $flyer;

    /**
     * Page constructor.
     * @param PageService $service
     * @param string $requestMethod
     * @param bool $flyer
     * @param string|null $param
     */
    public function __construct(PageService $service, string $requestMethod, bool $flyer, string $param = null)
    {
        parent::__construct($service, $requestMethod, $param);
        $this->flyer = $flyer;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        if ($this->flyer) {
            $response = $this->service->getAllByFlyerId($this->param);
        } else if ($this->param) {
            $response = $this->service->getItem($this->param);
        } else {
            $response = $this->notFoundResponse();
        }

        return $response;
    }

    /**
     * @param array $page
     * @return bool
     */
    public function validate(array $page): bool
    {
         if (!isset($page['dateValid']) || empty($page['dateValid'])) {
            return false;
        }
        if (!isset($page['dateExpired']) || empty($page['dateExpired'])) {
            return false;
        }
        if (!isset($page['pageNumber']) || empty($page['pageNumber'])) {
            return false;
        }
        if (!isset($page['flyerId']) || empty($page['flyerId'])) {
            return false;
        }

        return true;
    }
}
