<?php

namespace Webgriffe\LibTriveneto;

use Psr\Log\LoggerInterface;

class Client
{
    /**
     * @var LoggerInterface
     */
    private $logger = null;

    /**
     * @var string
     */
    private $userId = null;

    /**
     * @var string
     */
    private $password = null;

    /**
     * @var string
     */
    private $initUrl = null;

    /**
     * @var int
     */
    private $action = null;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function init($userId, $password, $initUrl, $action)
    {
        if (!$userId) {
            throw new \InvalidArgumentException('Missing user id');
        }

        if (!$password) {
            throw new \InvalidArgumentException('Missing password');
        }

        if (!$initUrl) {
            throw new \InvalidArgumentException('Missing payment init URL');
        }

        if (!$action) {
            throw new \InvalidArgumentException('Missing payment action (accounting type)');
        }

        $this->userId = $userId;
        $this->password = $password;
        $this->initUrl = $initUrl;
        $this->action = $action;
    }

    public function paymentInit()
    {
        if (!$this->wasInitCalled()) {
            throw new \Exception('Init was not called');
        }
    }

    public function paymentVerify()
    {
        if (!$this->wasInitCalled()) {
            throw new \Exception('Init was not called');
        }
    }

    private function wasInitCalled()
    {
        return !is_null($this->userId) && !is_null($this->password) && !is_null($this->initUrl) &&
            !is_null($this->action);
    }
}
