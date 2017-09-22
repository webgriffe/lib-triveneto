<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 05/09/17
 * Time: 16.55
 */

namespace Webgriffe\LibTriveneto\NotificationMessage\Response;

interface GeneratorInterface
{
    /**
     * @return string
     */
    public function generate();
}
