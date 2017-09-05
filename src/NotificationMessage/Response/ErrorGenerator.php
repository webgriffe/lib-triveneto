<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 05/09/17
 * Time: 16.54
 */

namespace Webgriffe\LibTriveneto\NotificationMessage\Response;

class ErrorGenerator extends AbstractGenerator
{
    protected function getResponseUrl()
    {
        return $this->errorUrl;
    }
}