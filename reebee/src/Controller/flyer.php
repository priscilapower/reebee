<?php
namespace Controller;

use Service\Flyer as FlyerService;

/**
 * Class Flyer
 * @package Controller
 */
class Flyer extends Controller {

    /**
     * Flyer constructor.
     * @param FlyerService $service
     * @param string $requestMethod
     * @param string|null $param
     */
    public function __construct(FlyerService $service, string $requestMethod, string $param = null)
    {
        parent::__construct($service, $requestMethod, $param);
    }

    /**
     * @param array $flyer
     * @return bool
     */
    protected function validate(array $flyer): bool
    {
        if (!isset($flyer['name']) || empty($flyer['name'])) {
            return false;
        }
        if (!isset($flyer['storeName']) || empty($flyer['storeName'])) {
            return false;
        }
        if (!isset($flyer['dateValid']) || empty($flyer['storeName'])) {
            return false;
        }
        if (!isset($flyer['dateExpired']) || empty($flyer['dateExpired'])) {
            return false;
        }
        if (!isset($flyer['pageCount']) || empty($flyer['pageCount'])) {
            return false;
        }

        return true;
    }
}
