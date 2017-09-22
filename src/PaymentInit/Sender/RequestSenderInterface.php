<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 15/09/17
 * Time: 15.09
 */

namespace Webgriffe\LibTriveneto\PaymentInit\Sender;

interface RequestSenderInterface
{
    /**
     * Checks whether this sender is available. FOr example it checks whether all required PHP extensions are available
     *
     * @return void
     */
    public function validate();

    /**
     * @param string $url
     * @param string $dataAsQueryString
     *
     * @return string
     */
    public function send($url, $dataAsQueryString);
}
