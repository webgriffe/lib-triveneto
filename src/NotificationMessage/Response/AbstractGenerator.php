<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 05/09/17
 * Time: 16.52
 */

namespace Webgriffe\LibTriveneto\NotificationMessage\Response;

abstract class AbstractGenerator implements GeneratorInterface
{
    /**
     * @var string
     */
    protected $successUrl;

    /**
     * @var string
     */
    protected $errorUrl;

    public function __construct($successUrl, $errorUrl)
    {
        $this->successUrl = $successUrl;
        $this->errorUrl = $errorUrl;
    }

    public function generate()
    {
        return "REDIRECT={$this->getResponseUrl()}";
    }

    abstract protected function getResponseUrl();
}
