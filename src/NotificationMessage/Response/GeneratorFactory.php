<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 05/09/17
 * Time: 16.56
 */

namespace Webgriffe\LibTriveneto\NotificationMessage\Response;

use Webgriffe\LibTriveneto\NotificationMessage\Result\NotificationResult;
use Webgriffe\LibTriveneto\NotificationMessage\Result\NotificationResultInterface;

class GeneratorFactory
{
    /**
     * @param NotificationResultInterface $result
     * @param string $successUrl
     * @param string $errorUrl
     *
     * @return GeneratorInterface
     */
    public function getGenerator(NotificationResultInterface $result, $successUrl, $errorUrl)
    {
        if ($result instanceof NotificationResult && ($result->getIsSuccess() || $result->getIsPending())) {
            return new SuccessGenerator($successUrl, $errorUrl);
        }

        return new ErrorGenerator($successUrl, $errorUrl);
    }
}
